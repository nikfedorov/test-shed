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
            'email' => 'nullable|email|max:255|unique:users',
            'name' => 'nullable|max:255',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($id);
        foreach ($validInput as $key => $value) {
            $user->$key = $validInput[$key];
            if ($key == 'password') {
                $user->password = Hash::make($validInput['password']);
            }
        }
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
