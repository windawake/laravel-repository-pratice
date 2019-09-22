<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register()
    {

        $email = request()->input('email');
        $password = Hash::make(request()->input('password'));
        $ret = Admin::where('email', $email)->first();
        if($ret) return response()->json(['error' => 'email exist'], 500);

        Admin::create(['email' => $email, 'password'=>$password]);
        return response()->json(['success' => 'registered successfully'], 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('backend')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => 'bearer '.$token,
            'expires_in' => auth('backend')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        $user = auth('backend')->user();
        return response()->json($user);
    }
}
