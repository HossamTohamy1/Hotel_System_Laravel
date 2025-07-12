<?php

namespace App\Services;


use App\Traits\HttpResponses;

use App\Http\Resources\RoomResource;
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

    public function getAllRooms()
    {
        $rooms = Room::all();
        return $this->Success(RoomResource::collection($rooms), 'Rooms retrieved successfully');
    }
    public function store($request)
    {
        $room = Room::create($request->validated());
        return $this->Success(RoomResource::make($room), 'Room created successfully', 201);
    }
    public function getRoomById($id)
    {
        $room = Room::find($id)->select('id', 'room_type', 'room_number', 'price_per_night', 'capacity', 'description', 'imagePath', 'available')->first();
        if (!$room) {
            return $this->Error(null, 'Room not found', 404);
        }
        return $this->Success(RoomResource::make($room), 'Room retrieved successfully');
        
    }
    public function update($id, $request)
    {
        $room = Room::find($id);
        if (!$room) {
            return $this->Error(null, 'Room not found', 404);
        }
        $room->update($request->validated());
        return $this->Success(RoomResource::make($room), 'Room updated successfully');
    }
    

}
