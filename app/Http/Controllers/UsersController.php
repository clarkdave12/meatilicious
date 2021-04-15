<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function register(Request $request) {

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        $role = Role::where('role', 'user')->first();

        $user->roles()->attach($role);

        return response()->json([
            'message' => 'User Registered',
            'user' => $user
        ], 201);

    }


    public function login(Request $request) {

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->with('roles')->first();

        $roles = $user->roles;

        if($roles[0]->role != 'user') {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $accessToken = $user->createToken('access_token')->accessToken;

        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $accessToken
        ], 200);
    }


    public function adminLogin(Request $request) {

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->with('roles')->first();

        $roles = $user->roles;

        if($roles[0]->role != 'admin') {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $accessToken = $user->createToken('access_token')->accessToken;

        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $accessToken
        ], 200);

    }

    public function isAdmin() {
        $auth = Auth::user();

        $user = User::where('id', $auth->id)->with('roles')->first();

        if($user->roles[0]->role != 'admin') {
            return response()->json([
                'message' => 'You are not authorized'
            ], 403);
        }

        return $user;
    }

}
