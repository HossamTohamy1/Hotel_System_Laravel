<?php

namespace App\Services;

use App\Traits\HttpResponses;
use App\Traits\HasGlobalScope;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Exceptions\BusinessLogicException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

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
    public function deleteRoom($id)
    {
        $room =Room::Find($id);
        if(!$room)
        {
            return $this->Error(null, 'Room not found', 404);
        }
        $room->delete();
        return $this->Success(null, 'Room deleted successfully', 204);

    }




public function updateAvailabilityForFinishedReservations()
{
    try {
        $today = Carbon::today();

        $rooms = Room::whereHas('reservations', function ($query) use ($today) {
            $query->where('check_out_date', '<', $today)
                  ->whereIn('status', ['pending', 'confirmed']); 
        })->get();

        $updatedCount = 0;

        foreach ($rooms as $room) {
            $room->available = true;
            $room->save();

            $room->reservations()
                ->where('check_out_date', '<', $today)
                ->whereIn('status', ['pending', 'confirmed']) 
                ->update(['status' => 'completed']);

            $updatedCount++;
        }

        return $this->Success(
            ['rooms_updated' => $updatedCount],
            'Room availability updated, and reservations marked as completed.',
            200
        );
    } catch (\Exception $e) {
        return $this->Error(null, 'Update failed: ' . $e->getMessage(), 500);
    }
}


}
