<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Perform authentication
     *
     * @param Request $request
     *
     * @return string
     */
    public function authenticate(Request $request)
    {
        // Validation field
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        // Test Verification
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect credentials'], 401);
        }

        return response()->json(compact('token'));
    }

    /**
     * Register a new user
     *
     * @param Request $request
     *
     * @return string
     */
    public function register(Request $request)
    {
        // Expression Verification
        $validInput = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create users and generate Token
        $user =  User::create([
            'name' => $validInput['name'],
            'email' => $validInput['email'],
            'password' => Hash::make($validInput['password']),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token'));
    }
}
