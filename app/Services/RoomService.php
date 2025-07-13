<?php

namespace App\Services;

use App\Traits\HttpResponses;
use App\Traits\HasGlobalScope;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Exceptions\BusinessLogicException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomService
{
    use HttpResponses,HasGlobalScope;

    public function __construct()
    {
        //
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
       $room = $this->getById(Room::class, $id);
        if (!$room) {
            return $this->Error(null,'Room not found', 404);
        }
        return $this->Success(RoomResource::make($room), 'Room retrieved successfully');
    }

    public function update($id, $request)
    {
        $room = Room::findOrFail($id);

        
        if (!$room->available) {
            throw new BusinessLogicException('Room is not available for update.');
        }

        $room->update($request->validated());

        return $this->Success(RoomResource::make($room), 'Room updated successfully');
    }
}
