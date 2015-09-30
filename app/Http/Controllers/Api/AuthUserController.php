<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthUserController extends Controller
{
    public function auth(Request $request){
        $email = $request->email;
        $password = $request->pwd;
        // return response()->json(['email' => $email, 'password' => $password]);



        if (\Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return response()->json(\Auth::user());
        }else{
        	return response()->json(array('msg' => 'user not found', 'status' => 0));
        }
    }
}
