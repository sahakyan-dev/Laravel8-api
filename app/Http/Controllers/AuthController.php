<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;
use Validator;
use App\Models\User;

class AuthController extends Controller {

    public function register(Request $request) {
        $requestRegister = $request->json()->all();

        $validator = Validator::make($requestRegister, [ 
            'name' => 'required|string',
            'lastname' => 'string',
            // 'image' => 'nullable|image',
            'image' => 'nullable|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'age' => 'string',
            'gender' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Not validate'], 401);
        }

        // if($request->file('image') != null) {
        //     $profile_image = $request->file('image')->store('users');
        // } else {
        //     $profile_image = NULL;
        // }

        $user = new User([
            'name' => $requestRegister["name"],
            'lastname' => $requestRegister["lastname"],
            'image' => $requestRegister["image"],
            'email' => $requestRegister["email"],
            'password' => Hash::make($requestRegister["password"]),
            'age' => $requestRegister["age"],
            'gender' => $requestRegister["gender"],
            'role' => 'user',
            'active' => 1,
        ]);

        $user->save();
        return response()->json(['message' => 'Register success'], 200);
    }

    public function login(Request $request) {
        $requestLogin = $request->json()->all();

        $validator = Validator::make($requestLogin, [ 
            'email' => 'required',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Not validate'], 401);
        }

        if(!Auth::guard('web')->attempt(['email' => $requestLogin['email'], 'password' => $requestLogin['password']])){
            return response()->json(['message' => 'Error With Login'], 401);
        }
        
        $user = Auth::guard('web')->user();
        if($user->active == 1) {
            $tokenResult = $user->createToken('Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            return response()->json(['data' => [
                'user' => Auth::user(),
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]]);
        } else {
            return response()->json(['message' => 'User is not active'], 401);
        }
    }
    
}