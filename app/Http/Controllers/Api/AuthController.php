<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{


    public function login(Request $request){

        $credentials = $request->only('email','password');
        if(!$token = Auth::attempt($credentials)){
            return response()->json([
                'success' => false
            ], 401);
        }
        return response()->json([
            'success' =>true,
            'token' => $token,
            'user' => Auth::user()
        ]);

    }


    
}
