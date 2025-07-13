<?php

namespace App\Services;

use App\Traits\HttpResponses;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Exceptions\BusinessLogicException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomService
{
    use HttpResponses;

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
        try {
                $room = Room::create($request->validated());    
                if (!$room) {
                    throw new BusinessLogicException('Failed to create the room.');
                }    
                return $this->Success(RoomResource::make($room), 'Room created successfully', 201);    
              } 
        
        catch (\Illuminate\Database\QueryException $e)
         {
            if (str_contains($e->getMessage(), 'room_number')) {
                throw new BusinessLogicException('This room number already exists.');
            }       
            
            throw new BusinessLogicException('A database error occurred while creating the room.');
            
        } catch (\Exception $e) {
            throw new BusinessLogicException('Unexpected error while creating room: ' . $e->getMessage());
        }
    }       


    public function getRoomById($id)
    {
       $room = Room::findOrFail($id);
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
