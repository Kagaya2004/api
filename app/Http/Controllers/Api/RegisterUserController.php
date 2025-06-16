<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterUserController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Erro nos dados informados pelo usuário',
                'erros' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('main')->plainTextToken;

        if ($user){
            User::sendVerificationEmail($user);
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso. Verifique seu e-mail para ativar sua conta.',
                'token' => $token,
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Erro no cadastro do usuário.',
                'status' => '500',
            ], 500);
        }
    }
}
