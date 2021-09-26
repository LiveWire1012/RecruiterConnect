<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelp;
use App\Models\Users;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $userData = $request->all();
        $userData['password'] = bcrypt($request->password);
        $user = AuthService::make()->registerService($userData);
        if(!$user) {
            return ResponseHelp::error('Another user already exists!');
        }
        return ResponseHelp::success('user created successfully');
    }

    public function login(Request $request) {
        $user = Users::where('email', $request->email)->first();
        if (empty($user)) {
            return response()->json(['message' => "The given user doesn't exist"]);
        }
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        }
        return response()->json(['message' => 'The given password is incorrect']);
    }

    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'You have been successfully logged out']);
    }
}
