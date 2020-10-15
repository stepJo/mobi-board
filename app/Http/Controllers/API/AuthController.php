<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try
        {
            $user = User::where('u_email', $request->u_email)->first();

            if($user && Hash::check($request->u_password, $user['u_password']))
            {
                $token = $user->createToken('app-token')->plainTextToken;
                
                Auth::login($user);

                return  response()->json([
                    'user'   => $user,
                    'token'  => $token, 
                    'status' => 200
                ], 200);
            }

            return response()->json([
                'message' => 'Credentials do not match our records',
                'status'  => 404
            ], 404);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }

    public function logout(Request $request) {
        try
        {
            //$request->user()->token()->delete();

            Auth::logout();

            return response()->json([
                'status' => 200
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }
}
