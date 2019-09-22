<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AffiliateController extends Controller
{
    public function register()
    {
        $email = request()->input('email');
        $password = Hash::make(request()->input('password'));
        $ret = Affiliate::where('email', $email)->first();
        if($ret) return response()->json(['error' => 'email exist'], 500);
        
        Affiliate::create(['email' => $email, 'password'=>$password]);
        return response()->json(['success' => 'registered successfully'], 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => 'bearer '.$token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

}
