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

    public function update(Request $request, $id)
    {
        $validInput = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        $user = User::findOrFail($id);

        $user->name = $validInput['name'];
        $user->email = $validInput['email'];
        $user->password = Hash::make($validInput['password']);
        $user->save();

        return $user->toJson();
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
