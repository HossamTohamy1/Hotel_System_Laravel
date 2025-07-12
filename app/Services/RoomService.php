<?php

namespace App\Services;

use App\Traits\HttpResponses;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Room; // Assuming you have a User model
// use App\Http\Resources\UserResource;

class RoomService
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
       
        return $this->Success(null, 'User created successfully', 201);
    }
    public function getRoomById($id)
    {
        
    }
    

}
