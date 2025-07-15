<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\HttpResponses;

class ReservationService
{
    use HttpResponses;

    public function makeReservation(array $data)
    {
        return DB::transaction(function () use ($data) {
            $room = Room::find($data['room_id']);

            if (!$room) {
                return $this->Error(null, "Room not found.", 404);
            }

            $overlap = Reservation::where('room_id', $room->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($data) {
                    $query->where('check_in_date', '<', $data['check_out_date'])
                              ->where('check_out_date', '>', $data['check_in_date']);
                    })->exists();


            if ($overlap) {
                return $this->Error(null, "Room not available for the selected dates.", 400);
            }

            $checkIn = Carbon::parse($data['check_in_date']);
            $checkOut = Carbon::parse($data['check_out_date']);
            $nights = $checkOut->diffInDays($checkIn);

            $pricePerNight = $room->price_per_night;

            if (!empty($data['offer_id'])) {
                $offer = Offer::find($data['offer_id']);
                if (!$offer || !$offer->rooms->contains($room->id)) {
                    return $this->Error(null, "Selected offer is not valid for this room.", 400);
                }

                if (!$offer->rooms->contains($room->id)) {
                    return $this->Error(null, "Selected offer is not valid for this room.", 400);
                }

                $today = Carbon::today();
                if ($today->lt(Carbon::parse($offer->start_date)) || $today->gt(Carbon::parse($offer->end_date))) {
                    return $this->Error(null, "Offer is not valid at this time.", 400);
                }

                $discount = $offer->discount_percentage;
                $pricePerNight -= ($pricePerNight * ($discount / 100)); 
            }

            $total = $pricePerNight * $nights;

            $reservation = Reservation::create(array_merge(
                $data,
                [
                    'room_id' => $room->id,
                    'total_amount' => $total,
                    'status' => 'pending',
                ]
            ));

            $room->available = false;
            $room->save();

            return $this->Success($reservation, 'Reservation successful.', 201);
        });
    }


    public function updateReservation($id, array $data)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return $this->Error(null, 'Reservation not found.', 404);
        }
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return $this->Error(null, 'Cannot edit a reservation that is completed or cancelled.', 400);
        }

        $newRoomId = $data['room_id'] ?? $reservation->room_id;
        $checkIn = $data['check_in_date'] ?? $reservation->check_in_date;
        $checkOut = $data['check_out_date'] ?? $reservation->check_out_date;


      $overlap = Reservation::where('room_id', $newRoomId)
             ->where('id', '!=', $reservation->id)
             ->whereIn('status', ['pending', 'confirmed'])
             ->where(function ($query) use ($checkIn, $checkOut) {
                 $query->where('check_in_date', '<', $checkOut)
                       ->where('check_out_date', '>', $checkIn);
             })->exists();


        if ($overlap) {
            return $this->Error(null, 'Room not available for the new dates.', 400);
        }

        $room = Room::find($newRoomId);
        if (!$room) {
            return $this->Error(null, "Room not found.", 404);
        }

        $nights = Carbon::parse($checkOut)->diffInDays(Carbon::parse($checkIn));
        $pricePerNight = $room->price_per_night;

        if (!empty($data['offer_id'])) {
            $offer = Offer::findOrFail($data['offer_id']);

            if (!$offer->rooms->contains($room->id)) {
                return $this->Error(null, 'Selected offer is not valid for this room.', 400);
            }

            $today = Carbon::today();
            if ($today->lt(Carbon::parse($offer->start_date)) || $today->gt(Carbon::parse($offer->end_date))) {
                return $this->Error(null, 'Offer is not valid at this time.', 400);
            }

            $discount = $offer->discount_percentage;
            $pricePerNight -= ($pricePerNight * ($discount / 100));
        }

        $total = $pricePerNight * $nights;

        $reservation->fill(array_merge(
            $data,
            [
                'room_id' => $newRoomId,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'total_amount' => $total,
            ]
        ))->save();

        return $this->Success($reservation, 'Reservation updated successfully.', 200);
    }

    public function cancelReservation($id)
    {
    $reservation = Reservation::find($id)->select( 'status')->first();
    if (!$reservation) {
        return $this->Error(null, 'Reservation not found.', 404);
    }

    if (!in_array($reservation->status, ['pending'])) {
        return $this->Error(null, 'Only pending reservations can be cancelled.', 400);
    }

    $reservation->status = 'cancelled';
    $reservation->save();

    $room = $reservation->room; 
    $room->available = true;
    $room->save();

    return $this->Success($reservation, 'Reservation cancelled successfully.', 200);
}
public function getReservationByRoomNumber(string $roomNumber)
{
    $reservation = Reservation::whereHas('room', function ($query) use ($roomNumber) {
    $query->where('room_number', $roomNumber);
                 })
                  ->latest()
                  ->first();


    if (!$reservation) {
        return $this->Error(null, 'Reservation not found for this room number.', 404);
    }

    return $this->Success($reservation, 'Reservation details retrieved successfully.');
}


}
