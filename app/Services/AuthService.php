<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\HttpResponses;



class AuthService
{
        use HttpResponses;
    /**
     * Create a new class instance.
     */

      public function register( $request)
    {
        $user = User::create($request->validated())->select('id', 'name', 'email')->first();

        $token = JWTAuth::fromUser($user);

        return $this->Success(['user' => $user,'token' => $token], 'User registered successfully', 201);
    }

    public function login($request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials))
            return $this->Error(null, 'Invalid email or password', 401);

        return $this->Success(['token' => $token], 'User logged in successfully', 200);
    }

    public function profile()
    {
        return $this->Success(auth()->user(), 'User retrieved successfully');
    }

    public function logout()
    {
        auth()->logout();
        return $this->Success(['message' => 'Successfully logged out']);
    }
}
