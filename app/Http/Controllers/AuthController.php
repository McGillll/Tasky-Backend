<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function authLogin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'email' => 'This email is not registered'
                ]
            ], 404);
        }

        $mismatchPassword = !Hash::check($request->password, $user->password);

        if($mismatchPassword){
            return response()->json([
                'message' => 'Invalid Password',
                'errors' => [
                    'password' => 'Invalid password'
                ]
            ], 400);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'data' => $user
        ], 200);

    }

    public function authLogout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message', 'Successfully Logout'
        ], 200);
    }
}
