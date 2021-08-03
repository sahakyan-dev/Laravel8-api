<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;
use App\Models\User;

class UsersController extends Controller {
    
    public function getUsers(Request $request) {
        $adminUser = $request->json()->all();
        $user = User::where('email' , $adminUser["email"])->first();

        if(isset($user)) {
            if($user->role == "admin") {
                $allUsers = User::where('role' , 'user')->get();
                return response()->json(['data' => $allUsers]);
            } else {
                return response()->json(['message' => 'Role is not admin'], 401);
            }
        } else {
            return response()->json(['message' => 'This email does not exist'], 401);
        }
    }

    public function editUser(Request $request) {
        $editUser = $request->json()->all();

        $user = User::where('email' , $editUser["email"])->first();
        if(isset($user)) {
            $user->active = $editUser["active"];
            $user->save();
            return response()->json(['message' => 'User updated'], 200);
        } else {
            return response()->json(['message' => 'This email does not exist'], 401);
        }
    }
}
