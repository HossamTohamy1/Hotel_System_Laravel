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
    public function getAllUsers()
    {
        $users = User::select('id', 'name', 'email')->get();
        return $this->Success(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function store($request)
    {
        $user = User::create($request->validated())->select('id', 'name', 'email')->first();
        $user= new UserResource($user);
        return $this->Success($user, 'User created successfully', 201);
    }


    public function getUserById($id)
    {
        $user = User::find($id)->select('id', 'name', 'email')->first();
        if (!$user) {
            return $this->Error(null, 'User not found', 404);
        }
        return $this->Success( UserResource::make($user), 'User retrieved successfully');
    }
    

}
