<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
use App\Models\User;

class NewPasswordController extends Controller {

    public function getForgotPasswordToken(Request $request) {
        $getTokens = $request->json()->all();
        $userTokens = User::where('email' , $getTokens['email'])->first();
        // $user = Auth::guard('web')->user();
        $tokens = $userTokens->tokens();
        
        return response()->json($userTokens, 200);
        // access token y get anem
    }

    public function forgotPassword(Request $request) {
        $requestForgotPasswordEmail = $request->json()->all();

        $validator = Validator::make($requestForgotPasswordEmail, [ 
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Not validate'], 401);
        }
        
        if(Mail::to($requestForgotPasswordEmail['email'])->send(new ForgotPassword()))
            return response()->json($requestForgotPasswordEmail['email'], 200);
    }

    public function resetPassword(Request $request) {
        $requestResetPasswordEmail = $request->json()->all();
        
        $validator = Validator::make($requestResetPasswordEmail, [ 
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Not validate'], 401);
        }
        
        $passwordChangeUser = User::where('email' , $requestResetPasswordEmail['email'])->first();
        $passwordChangeUser->password = Hash::make($requestResetPasswordEmail['password']);
        $passwordChangeUser->remember_token = Str::random(60);
        if($passwordChangeUser->save()) {
            $passwordChangeUser->tokens()->delete();
            return response()->json(['message' => 'Password reset Successfully'], 200);
        } else {
            return response()->json(['message' => 'Password not reset'], 401);
        }

    }
}
