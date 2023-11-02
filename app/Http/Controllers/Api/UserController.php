<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => __('messages.user_not_found'),
                'status' => '0',
            ]);
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'message' => __('messages.wrong_password'),
                'status' => '0',
            ]);
        }
        return response()->json([
            'data' => $user,
            'token' => $user->createToken($request->header('User-Agent') ?? $request->ip())->plainTextToken,

            'message' => __('messages.user_login'),
            'status' => '1'
        ]);
    }
    public function register(Request $request) {
       $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
       ]);

        return response()->json([
            'data' => $user,
            'message' => __('messages.user_register'),
            'status' => '1'
        ]);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => "User Logout Succesfully",
            'status' => '1',
        ]);
    }
}
