<?php

namespace App\Services;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Room;

use App\Traits\HttpResponses;
class OfferService
{
    use HttpResponses;
    public function createOffer( $data)
    {

        $offer = Offer::create($data->validated());
        $roomNumbers = $data->get('room_numbers') ?? [];
        $roomIds = Room::whereIn('room_number', $roomNumbers)->pluck('id')->toArray();
        $offer->rooms()->sync($roomIds);
        return $this->Success(OfferResource::make($offer), 'Offer created successfully', 201);
    }
}
