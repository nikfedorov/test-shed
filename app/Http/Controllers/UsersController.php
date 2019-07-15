<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return User::all()->toJson();
    }

    public function create(Request $request)
    {
        $validInput = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        $user =  User::create([
            'name' => $validInput['name'],
            'email' => $validInput['email'],
            'password' => Hash::make($validInput['password']),
        ]);

        return $user->toJson();
    }
}
