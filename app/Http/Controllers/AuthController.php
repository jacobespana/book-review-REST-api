<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class AuthController extends Controller
{
    /**
    * Register a user  
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */  
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }
     /**
    * Allow user to login to system  
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */ 
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
     /**
    * Get the token array structure 
    * @param  $token
    * @return \Illuminate\Http\Response
    */ 
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
