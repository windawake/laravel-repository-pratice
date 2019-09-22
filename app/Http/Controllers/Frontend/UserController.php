<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingsUpdateRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Affiliate;
use App\Repositories\AffiliateRepository;
use App\Transformers\AffiliateTransformer;
use Illuminate\Support\Arr;
use App\Criteria\ManagerCriteria;
use App\Fakers\MapFaker;
use App\Helpers\GenerateCode;
use App\Helpers\SendEmail;
use App\Http\Requests\Backend\AffiliateBillingUpdateRequest;
use App\Http\Requests\Frontend\PasswordUpdateRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Models\Admin;
use App\Models\AffiliateBilling;
use App\Repositories\AffiliateBillingRepository;
use App\Transformers\AffiliateBillingTransformer;
use Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    /**
     * @var AffiliateRepository
     */
    protected $affRepository;
    protected $affBilling;


    public function __construct(AffiliateRepository $aff, AffiliateBillingRepository $affBilling)
    {
        $this->affRepository = $aff;
        $this->affBilling = $affBilling;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return apiResponse([], 500, 'email or password incorrect');
        }

        $aff = Affiliate::find(auth()->id());
        if($aff->status == MapFaker::AFF_STATUS_PENDING){
            return apiResponse([], 500, 'pending status');
        }

        if($aff->status == MapFaker::AFF_STATUS_REJECTED){
            return apiResponse([], 500, 'rejected status');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $token = auth()->user();
        return apiResponse(['access_token' => $token], 200, '校验成功');
    }
    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return apiResponse([], 200, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * 发送重置邮箱
     */
    public function password_email()
    {
        $email = request()->input('email');
        $affiliate  = Affiliate::where(['email' => $email])->first();
        if(!$affiliate){
            return apiResponse('the email not exist', 503);
        }
        $token = JWTAuth::fromUser($affiliate);

        $info = [
            'email' => $affiliate->email,
            'user_name' => $affiliate->affiliate_name,
            'content' => '<h3>read book</h3>',
            'jump_url' => 'http://front.esmtong.cn/user/forgetPassword?email='.$affiliate->email.'&token='.$token,
        ];

        $ret = SendEmail::requestResetPassword($info);
        
        if($ret){
            return apiResponse('The email was successfully sent. Please check it');
        }else{
            return apiResponse('Email failed, please try again!', 503);
        }
    }

    /**
     * 重置密码
     */
    public function password_reset()
    {
        $email = request()->input('email');
        $password = request()->input('password');

        try {
            $affiliate = JWTAuth::parseToken()->authenticate();

            if($affiliate->email != $email){
                return \apiResponse('Email is not the email you log in to', 500);
            }
            $affiliate->password = Hash::make($password);
            $affiliate->save();

            $info = [
                'email' => $affiliate->email,
                'user_name' => $affiliate->affiliate_name,
                'content' => '重置密码成功',
            ];
    
            SendEmail::resetPassword($info);

            return apiResponse('Password set successfully');
        } catch(TokenExpiredException $e){
            return \apiResponse($e->getMessage(), 500);
        }
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $aff_id = auth()->id();
        $this->affRepository->pushCriteria(ManagerCriteria::class);
        $affiliate = $this->affRepository
        ->select('affiliate.email','admin.email as admin_email','affiliate.timezone_id')
        ->find($aff_id);
        $timezoneId = $affiliate->timezone_id ?: MapFaker::DEFAULT_TIMEZONE_ID;
        
        return apiResponse([
            'access_token' => 'bearer '.$token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'email' => $affiliate->email,
            'manager_email' => $affiliate->admin_email,
            'timezone_id' => $timezoneId,
        ]);
    }

    public function register(RegisterRequest $request)
    {

        $email = $request->input('user_detail.email');
        $ret = $this->affRepository->findWhere(['email' => $email])->first();

        if($ret){
            return apiResponse('It has already registered');
        }

        $inData = array_merge(
            $request->input('user_detail'), 
            $request->input('affiliate_detail')
        );

        $inData['password'] = Hash::make($inData['password']);
        $inData['affiliate_code'] = GenerateCode::affiliate();
        AffiliateTransformer::rebuild($inData);

        $ret =  $this->affRepository->create($inData);

        if($ret){
            return apiResponse('registered successfully');
        }else{
            return apiResponse('registration failed', 500);
        }
    }

    /**
     * 修改密码
     */
    public function password_update(PasswordUpdateRequest $request)
    {
        $email = $request->input('email');
        $orignPassword = $request->input('origin_password');
        $password = $request->input('password');

        $affiliate = JWTAuth::parseToken()->authenticate();
        if($affiliate->email != $email){
            return \apiResponse('Email is not the email you log in to', 500);
        }

        $credentials = ['email' => $email, 'password'=>$orignPassword];
        $ret = auth()->once($credentials);
        if(!$ret){
            return \apiResponse('The original password is wrong', 500);
        }

        $affiliate->password = Hash::make($password);
        $affiliate->save();

        $info = [
            'email' => $email,
            'content' => '修改密码成功',
        ];

        SendEmail::changePassword($info);
        return apiResponse('Password changed successfully');
    }


}
