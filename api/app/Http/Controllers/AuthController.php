<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login (Request $request) 
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials) === false) {
            return response()->json('Unauthorized', 401);
        }
    
        $user = Auth::user();
        $token = $user->createToken('token');
    
        return response()->json($token->plainTextToken);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'funcionario',
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function logout (Request $request) 
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
