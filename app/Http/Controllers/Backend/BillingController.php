<?php

namespace App\Http\Controllers\Backend;

use App\Criteria\AffiliateCriteria;
use App\Fakers\MapFaker;
use App\Helpers\GenerateCode;
use App\Http\Requests\Backend\BillingUpdateRequest;
use App\Repositories\BillingRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BillingBatchStatusRequest;
use App\Http\Requests\Backend\BillingCreateRequest;
use App\Http\Requests\Backend\BillingPreviewRequest;
use App\Models\Affiliate;
use App\Models\Billing;
use App\Models\Bonus;
use App\Models\Offer;
use App\Models\Order;
use App\Transformers\BillingTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 *
 * @package namespace App\Http\Controllers\Backend;
 */
class BillingController extends Controller
{
    /**
     * @var BillingRepository
     */
    protected $billing;

    protected $validator;

    /**
     * BillingController constructor.
     *
     * @param BillingRepository $billing
     */
    public function __construct(BillingRepository $billing)
    {
        $this->billing = $billing;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->billing->pushCriteria(AffiliateCriteria::class);
        $this->billing->scopeQuery(function($query){
            $query->addSelect(BillingTransformer::select());
            $query = BillingTransformer::where($query);
            $query = BillingTransformer::order($query);

            return $query;
        });


        $list = $this->billing->paginate();
        return apiResponse($list);
    }

    public function show()
    {
        $billingId = request()->input('billing_id');

        $this->billing->pushCriteria(AffiliateCriteria::class);
        $this->billing->scopeQuery(function($query){
            $query->addSelect(BillingTransformer::select());
            return $query;
        });

        $billingDetail = $this->billing->find($billingId);
        if(!$billingDetail){
            return apiResponse('billing not exist', 500);
        }

        if($billingDetail['billing_type'] == MapFaker::BILLING_TYPE_REVENUE){
            $query = Order::affSharding($billingDetail['affiliate_id']);
            $table = $query->getModel()->getTable();
            $rawTable = DB::getTablePrefix().$table;

            $offerList = $query->leftJoin('offer','offer.id','=',$table.'.offer_id')->where('billing_id',$billingId)->select([
                'offer.offer_code',
                'offer.name as offer_name',
                $table.'.payout',
                DB::raw('sum('.$rawTable.'.confirmed_flag) as conversions'),
                DB::raw('sum('.$rawTable.'.payout) as amount'),
            ])->groupBy($table.'.offer_id')->get();

            $billingDetail['offer_list'] = $offerList;
        }elseif($billingDetail['billing_type'] == MapFaker::BILLING_TYPE_REPEAT){
            $query = Bonus::where('billing_id', $billingId);
            $table = $query->getModel()->getTable();
            $offerList = $query->leftJoin('offer','offer.id','=',$table.'.offer_id')
            ->select([
                $table.'.offer_id',
                'offer.offer_code',
                'offer.name as offer_name',
                'offer.payout',
                $table.'.source_order_no as order_no',
                DB::raw('sum(t_bonus.repeat_order_count) as repeat_order_count'),
                DB::raw('sum(t_bonus.amount) as amount'),
            ])->groupBy('offer_id')->get();
            $billingDetail['offer_list'] = $offerList;
        }

        return apiResponse($billingDetail);
    }

    public function preview(BillingPreviewRequest $request)
    {
        $billingType = request()->input('billing_type');
        $billingDetail = [];
        $amount = 0;
        $affiliateId = 0;
        $items = null;
        $idArr = [];

        if($billingType == MapFaker::BILLING_TYPE_BONUS || $billingType == MapFaker::BILLING_TYPE_REPEAT){
            $bonusIdArr = $request->input('bonus_id');
            $idArr = $bonusIdArr;
            $bonusType = Arr::get(MapFaker::getBillingBonusMap(), $billingType);
            $items = Bonus::whereIn('id', $bonusIdArr)->select(
                ['affiliate_id', 'type', 'amount']
            )->get();
            $affCount = $typeCount = 0;
            
            $affArr = $typeArr = [];
            foreach($items as $item){
                //已经生成billing不能再次生成
                if($item->billing_id){
                    return apiResponse('billing Has been created', 500);
                }

                if(!in_array($item->affiliate_id, $affArr)){
                    $affCount++;
                    $affArr[] = $item->affiliate_id;
                    $affiliateId = $item->affiliate_id;
                }
                if(!in_array($item->type, $typeArr)){
                    $typeCount++;
                    $typeArr[] = $item->type;
                }

                if($item->type != $bonusType){
                    return apiResponse('billing Type not match', 500);
                }
                

                $amount += $item->amount;
            }

            if($affCount > 1){
                return apiResponse('affiliate_id more than one', 500);
            }

            if($typeCount > 1){
                return apiResponse('type more than one', 500);
            }

        }else if($billingType == MapFaker::BILLING_TYPE_REVENUE){
            $orderIdInput = $request->input('order_id');
            $items = [];
            foreach($orderIdInput as $input){
                $orderArr = explode('_',$input);
                $aff_id = $orderArr[0];
                $orderId = $orderArr[1];
                $item = Order::affSharding($aff_id)->find($orderId);
                $idArr[] = $orderId;
                $items[] = $item;
            }

            $affCount = 0;
            
            $affArr = [];
            foreach($items as $item){
                //已经生成billing不能再次生成
                if($item->billing_id){
                    return apiResponse('billing Has been created', 500);
                }

                if(!in_array($item->affiliate_id, $affArr)){
                    $affCount++;
                    $affArr[] = $item->affiliate_id;
                    $affiliateId = $item->affiliate_id;
                }

                if($item->order_status != MapFaker::ORDER_STATUS_PAID){
                    return apiResponse('order status is not paid', 500);
                }

                $amount += $item->payout;
            }

            if($affCount > 1){
                return apiResponse('affiliate_id more than one', 500);
            }
        }

        if(!$items){
            return apiResponse('没找到记录', 500);
        }

        if($billingType == MapFaker::BILLING_TYPE_REVENUE){
            $query = Order::affSharding($affiliateId);
            $table = $query->getModel()->getTable();
            $rawTable = DB::getTablePrefix().$table;

            $offerList = $query->leftJoin('offer','offer.id','=',$table.'.offer_id')->whereIn($table.'.id', $idArr)->select([
                'offer.offer_code',
                'offer.name as offer_name',
                $table.'.payout',
                DB::raw('sum('.$rawTable.'.confirmed_flag) as conversions'),
                'order_no',
                DB::raw('sum('.$rawTable.'.payout) as amount'),
            ])->groupBy($table.'.offer_id')->get();

            $billingDetail['offer_list'] = $offerList;
        }elseif($billingType == MapFaker::BILLING_TYPE_REPEAT){
            $query = Bonus::whereIn('bonus.id',$idArr);
            $table = $query->getModel()->getTable();
            $offerList = $query->leftJoin('offer','offer.id','=',$table.'.offer_id')
            ->select([
                $table.'.offer_id',
                'offer.offer_code',
                'offer.name as offer_name',
                'offer.payout',
                $table.'.source_order_no as order_no',
                DB::raw('sum(t_bonus.repeat_order_count) as repeat_order_count'),
                DB::raw('sum(t_bonus.amount) as amount'),
            ])->groupBy('offer_id')->get();

            $billingDetail['offer_list'] = $offerList;
        }
        
        $aff = Affiliate::find($affiliateId);

        $billingDetail['total_amount'] = $amount;
        $billingDetail['affiliate_id'] = $affiliateId;
        $billingDetail['affiliate_name'] = $aff->affiliate_name;
        $billingDetail['affiliate_code'] = $aff->affiliate_code;


        return apiResponse($billingDetail); 
    }

    public function store(BillingCreateRequest $request)
    {
        $inData = $request->all();
        $billingType = $request->input('billing_type');
        $amount = 0;
        $affiliateId = 0;
        $items = null;

        if($billingType == MapFaker::BILLING_TYPE_BONUS || $billingType == MapFaker::BILLING_TYPE_REPEAT){
            $bonusIdArr = $request->input('bonus_id');
            $bonusType = Arr::get(MapFaker::getBillingBonusMap(), $billingType);
            $items = Bonus::whereIn('id', $bonusIdArr)->select(
                ['affiliate_id', 'type', 'amount']
            )->get();
            $affCount = $typeCount = 0;
            
            $affArr = $typeArr = [];
            foreach($items as $item){
                //已经生成billing不能再次生成
                if($item->billing_id){
                    return apiResponse('billing Has been created', 500);
                }

                if(!in_array($item->affiliate_id, $affArr)){
                    $affCount++;
                    $affArr[] = $item->affiliate_id;
                    $affiliateId = $item->affiliate_id;
                }
                if(!in_array($item->type, $typeArr)){
                    $typeCount++;
                    $typeArr[] = $item->type;
                }

                if($item->type != $bonusType){
                    return apiResponse('billing Type not match', 500);
                }
                

                $amount += $item->amount;
            }

            if($affCount > 1){
                return apiResponse('affiliate_id more than one', 500);
            }

            if($typeCount > 1){
                return apiResponse('type more than one', 500);
            }

        }else if($billingType == MapFaker::BILLING_TYPE_REVENUE){
            $orderIdInput = $request->input('order_id');
            $items = [];
            foreach($orderIdInput as $input){
                $orderArr = explode('_',$input);
                $aff_id = $orderArr[0];
                $orderId = $orderArr[1];
                $item = Order::affSharding($aff_id)->find($orderId);
                $items[] = $item;
            }

            $affCount = 0;
            
            $affArr = [];
            foreach($items as $item){
                //已经生成billing不能再次生成
                if($item->billing_id){
                    return apiResponse('billing Has been created', 500);
                }

                if(!in_array($item->affiliate_id, $affArr)){
                    $affCount++;
                    $affArr[] = $item->affiliate_id;
                    $affiliateId = $item->affiliate_id;
                }

                if($item->order_status != MapFaker::ORDER_STATUS_PAID){
                    return apiResponse('order status is not paid', 500);
                }

                $amount += $item->payout;
            }

            if($affCount > 1){
                return apiResponse('affiliate_id more than one', 500);
            }
        }

        if(!$items){
            return apiResponse('没找到记录', 500);
        }
        

        $inData['billing_code'] = GenerateCode::billing();
        $inData['total_amount'] = $amount;
        $inData['affiliate_id'] = $affiliateId;

        BillingTransformer::rebuild($inData);
        $billing = Billing::create($inData);
        if($billingType == MapFaker::BILLING_TYPE_BONUS || $billingType == MapFaker::BILLING_TYPE_REPEAT){
            Bonus::whereIn('id', $bonusIdArr)->update(['billing_id'=>$billing->id]);
        }else if($billingType == MapFaker::BILLING_TYPE_REVENUE){
            foreach($items as $item){
                Order::affSharding($item->affiliate_id)->find($item->id)->update(['billing_id'=>$billing->id]);
            }
        }

        return apiResponse();
    }

    // 更新
    public function update(BillingUpdateRequest $request)
    {
        $billingId = $request->input('billing_id');
        $upData = $request->all();
        BillingTransformer::rebuild($upData);
        $billing = Billing::find($billingId);
        if(!$billing){
            return apiResponse('billing not exist', 500);
        }

        $ret = $billing->update($upData);
        return apiResponse();
    }


   
    public function batch_status(BillingBatchStatusRequest $request)
    {
        $idArr = $request->input('billing_id_arr');
        $status = $request->input('billing_status');
        $billing =Billing::whereIn('id',$idArr);
        $upData = [
            'status' => $status,
        ];

        if($status == MapFaker::STATUS_PAID){
            $upData['paid_time'] = time();
        }else{
            $upData['paid_time'] = null;
        }
        $billing->update($upData);

        return apiResponse();
    }

    // 批量更新状态
    public function destroy()
    {
        $id = request()->input('billing_id');
        $billing = Billing::find($id);
        if($billing->type == MapFaker::BILLING_TYPE_REVENUE){
            Order::affSharding($billing->affiliate_id)->where('billing_id', $billing->id)->update(['billing_id'=>null]);
        }else{
            Bonus::where('billing_id', $billing->id)->update(['billing_id'=>null]);
        }
        $billing->delete();

        return \apiResponse();
    }


}
