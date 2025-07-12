<?php

namespace App\Services;

use App\Models\Offer;

class OfferService
{
    public function createOffer(array $data): Offer
    {
        $roomIds = $data['room_ids'] ?? [];
        unset($data['room_ids']);

        $offer = Offer::create($data);
        $offer->rooms()->sync($roomIds);

        return $offer->load('rooms');
    }
}
