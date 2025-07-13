<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Room;
use App\Traits\HttpResponses;

class OfferService
{
    use HttpResponses;

    public function createOffer($data)
    {
       
            $offer = Offer::create($data->validated());

            $roomNumbers = $data->get('room_numbers') ?? [];

            if (empty($roomNumbers)) {
                return $this->Error(null, 'At least one room number is required.', 400);
            }

            $roomIds = Room::whereIn('room_number', $roomNumbers)->pluck('id')->toArray();

            if (count($roomIds) !== count($roomNumbers)) {
                return $this->Error(null, 'One or more room numbers were not found.', 404);
            }

            $offer->rooms()->sync($roomIds);

            return $this->Success(OfferResource::make($offer), 'Offer created successfully', 201);

    
    }
    public function updateOffer($id, $data)
    {
       
            $offer = Offer::find($id);
            $offer->update($data->validated());

            $roomNumbers = $data->get('room_numbers') ?? [];

            if (empty($roomNumbers)) {
                return $this->Error(null, 'At least one room number is required.', 400);
            }

            $roomIds = Room::whereIn('room_number', $roomNumbers)->pluck('id')->toArray();

            if (count($roomIds) !== count($roomNumbers)) {
                return $this->Error(null, 'One or more room numbers were not found.', 404);
            }

            $offer->rooms()->sync($roomIds);

            return $this->Success(OfferResource::make($offer), 'Offer updated successfully');

       
    }
}
