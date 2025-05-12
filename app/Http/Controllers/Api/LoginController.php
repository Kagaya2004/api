<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email )->first();

        if (!$user){
            return response()->json([
                'message'=>'Email não encontrado',
            ]);
        }

        if (!Hash::check($password, $user->password)){
            
        }

        return response()->json([
            'email'=>$email,
            'password'=>$password,
        ]);
    }
}
