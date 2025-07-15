<?php

namespace App\Http\Controllers;
use App\Services\ReservationService;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequests\StoreReservationRequest;
use App\Http\Requests\ReservationRequests\UpdateReservationRequest;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }
  
     public function store(StoreReservationRequest $request)
   {
    return $this->reservationService->makeReservation($request->validated());
   }



  
    public function update(UpdateReservationRequest $request, $id)
  {
    return $this->reservationService->updateReservation($id, $request->validated());
  }
  public function cancel($id): JsonResponse
{
    return $this->reservationService->cancelReservation($id);
}
public function showByRoomNumber($roomNumber)
{
    return $this->reservationService->getReservationByRoomNumber($roomNumber);
}


  
}
