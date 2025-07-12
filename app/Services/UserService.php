<?php

namespace App\Services;

use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Models\User; // Assuming you have a User model
use App\Http\Resources\UserResource;

class UserService
{
    use HttpResponses;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }

    public function store($request)
    {
        $user = User::create($request->validated());
        $user= new UserResource($user);
        return $this->Success($user, 'User created successfully', 201);
    }
    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->Error(null, 'User not found', 404);
        }
        return $this->Success($user, 'User retrieved successfully');
    }
    

}
