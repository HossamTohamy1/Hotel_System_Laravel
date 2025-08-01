<?php

namespace App\Http\Controllers;
use App\Http\Requests\RoomRequests\StoreRoomRequest;
use App\Http\Requests\RoomRequests\UpdateRoomRequest;
use Illuminate\Http\Request;
use App\Services\RoomService;
use App\Models\Room;
use Illuminate\Http\JsonResponse;


class RoomController extends Controller
{
    protected $RoomService;
    public function __construct(RoomService $RoomService)
    {
        $this->RoomService= $RoomService;
    }

    public function index()
    {
        return $this->RoomService->getAllRooms();
    }


    public function store(StoreRoomRequest $request)
    {
        return $this->RoomService->store($request);
    }


    public function show($id)
    {
        return $this->RoomService->getRoomById($id);
    }


    public function update($id, UpdateRoomRequest $request)
    {
        return $this->RoomService->update($id, $request);
    }


    public function destroy($id)
    {
        return $this->RoomService->deleteRoom($id);
    }

   public function updateAvailability()
   {
    return $this->RoomService->updateAvailabilityForFinishedReservations();
   }
   

}
