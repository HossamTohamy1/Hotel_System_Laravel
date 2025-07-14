<?php

namespace App\Services;

use App\Models\Room;
use App\Models\offer;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Error;
use Illuminate\Support\Facades\DB;
use App\Traits\HttpResponses;

use App\Http\Requests\ReservationRequests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Before;

class ReservationService
{
    use HttpResponses;
    public function createReservation( $request)
{
    $data = $request->validated();
    dd("Before");
    return DB::transaction(function () use ($data) {
        try {
                dd("after Try");

            $room = Room::findOrFail($data['room_id']);

            $this->validateRoomAvailability($room->id, $data['check_in_date'], $data['check_out_date']);

            $this->validateGuestCapacity($room, $data['number_of_guests']);

            $this->validateReservationDates($data['check_in_date'], $data['check_out_date']);

            $totalPrice = $this->calculateTotalPrice($room, $data['check_in_date'], $data['check_out_date']);

            $reservation = Reservation::create([
                'user_id' => 1,
                'room_id' => $room->id,
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'number_of_guests' => $data['number_of_guests'],
                'total_price' => $totalPrice,
                'status' => ReservationStatus::PENDING,
            ]);

            $reservation->load(['room', 'user']);


            return $this->success(
                ReservationResource::make($reservation),
                'Reservation created successfully.',
                201
            );

        } catch (\Exception $e) {
            return $this->error(
                null,
                $e->getMessage(),
                500
            );
        }
    }); 
}
private function calculateTotalPrice(Room $room, string $checkIn, string $checkOut): float
{
    $checkInDate = Carbon::parse($checkIn);
    $checkOutDate = Carbon::parse($checkOut);
    $nights = $checkInDate->diffInDays($checkOutDate);
    
    $basePrice = $room->price_per_night * $nights;
    
      $activeOffer = $room->offers()
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->first();

    $discount = $activeOffer?->discount_percentage ?? 0;

  $discountAmount = $basePrice * ($discount / 100);
  $totalPrice = $basePrice - $discountAmount;
  
  return round($totalPrice, 2);
}
private function validateReservationDates(string $checkIn, string $checkOut): ?\Illuminate\Http\JsonResponse
{
    $checkInDate = Carbon::parse($checkIn);
    $checkOutDate = Carbon::parse($checkOut);

    if ($checkInDate->isPast()) {
        return $this->Error(null, 'Check-in date cannot be in the past.', 422);
    }

    if ($checkOutDate->isBefore($checkInDate)) {
        return $this->Error(null, 'Check-out date must be after check-in date.', 422);
    }

    if ($checkInDate->isSameDay($checkOutDate)) {
        return $this->Error(null, 'Check-out date must be at least one day after check-in date.', 422);
    }

    if ($checkInDate->diffInDays($checkOutDate) > 30) {
        return $this->Error(null, 'Maximum reservation length is 30 days.', 422);
    }

    return null; 
}
private function validateRoomAvailability(int $roomId, string $checkIn, string $checkOut)
{
    $conflictingReservation = Reservation::where('room_id', $roomId)
        ->where('status', '!=', ReservationStatus::CANCELLED->value)
        ->where(function ($query) use ($checkIn, $checkOut) {
            $query->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<', $checkOut)
                  ->where('check_out_date', '>', $checkIn);
            });
        })
        ->exists();

    if ($conflictingReservation) {
        return $this->Error(null, 'Room is not available for the selected dates.', 422);
    }

    return null;
}

private function validateGuestCapacity(Room $room, int $numberOfGuests)
{
    if ($numberOfGuests > $room->capacity) {
        return $this->Error(
            null,
            "Number of guests ({$numberOfGuests}) exceeds room capacity ({$room->capacity}).",
            422
        );
    }

    if ($numberOfGuests <= 0) {
        return $this->Error(
            null,
            'Number of guests must be at least 1.',
            422
        );
    }

    return null; 
}



}
