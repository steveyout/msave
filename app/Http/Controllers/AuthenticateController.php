<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    //authenticate and login user
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember=false;
        if ($request->has('remember_me')){
            $remember=true;
        }

        if (Auth::attempt($credentials,$remember)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'msg' => 'Login success',
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'User doesnt exist or password is invalid',
        ]);
    }
}
