<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ILluminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class VerifyUserAccountController extends Controller
{
    public function verifyUserAccount(Request $request)
    {
        $user = User::where('remember_token', $request->token)->first();
        
        logger("request->token: " . $request->token);
        if ($user)
        {
            logger("Passou");
            $user->remeber_token = null;
            $user->email_verified_at = Carbon::now();
            $user->ativo = true;
            $user->save();

            return User::sendEmailUserActivated($user);
        }
        else
        {
            return User::sendEmailUserActivatedFailed($user);
        }
    }
}