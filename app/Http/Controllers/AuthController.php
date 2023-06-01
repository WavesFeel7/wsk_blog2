<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use App\Role;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function registration()
    {
        try {
            $name = request('name');
            $email = request('email');
            $password = request('password');
            $role_id = request('role_id');

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->role_id = $role_id;
            $user->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['status' => 'invalid', 'message' => 'Wrong  email  or  password']);
        }

        // $token = JWTAuth::customClaims(['role' => $role->role, 'user' => $user])->attempt($credentials);
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        auth()->logout();
        return response()->json(['status' => 'success']);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'token' => $token,
        ]);
    }
}
