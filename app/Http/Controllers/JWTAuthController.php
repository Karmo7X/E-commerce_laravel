<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{

    // user regisertration
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }

    // user login
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            // Get the authenticated user.
            $user=auth()->user();
            // (optional) Attach the role to the token.
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token'));
        }catch (JWTException $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Get authenticated user
    public function getUser(){
        try {
          if(!$user=JWTAuth::parseToken()->authenticate()){
            return response()->json(['user_not_found'], 404);
          }
        }catch (JWTException $e){
            return response()->json(['error' => 'Invalid token'], 400);
        }
        return response()->json(compact('user'));
    }
    public  function update(Request $request){

    }
    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }


}
