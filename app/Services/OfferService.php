<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Room;
use App\Traits\HttpResponses;
use App\Exceptions\BusinessLogicException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class OfferService
{
    use HttpResponses;

    public function createOffer($data)
    {
        try {
            $offer = Offer::create($data->validated());

            $roomNumbers = $data->get('room_numbers') ?? [];

            if (empty($roomNumbers)) {
                throw new BusinessLogicException('At least one room number is required.');
            }

            $roomIds = Room::whereIn('room_number', $roomNumbers)->pluck('id')->toArray();

            if (count($roomIds) !== count($roomNumbers)) {
                throw new ModelNotFoundException('One or more room numbers were not found.');
            }

            $offer->rooms()->sync($roomIds);

            return $this->Success(OfferResource::make($offer), 'Offer created successfully', 201);

        } catch (QueryException $e) {
            throw new BusinessLogicException('A database error occurred while creating the offer.');
        
        } catch (\Exception $e) {
            throw new BusinessLogicException('Unexpected error while creating the offer: ' . $e->getMessage());
        }
    }
    public function updateOffer($id, $data)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->update($data->validated());

            $roomNumbers = $data->get('room_numbers') ?? [];

            if (empty($roomNumbers)) {
                throw new BusinessLogicException('At least one room number is required.');
            }

            $roomIds = Room::whereIn('room_number', $roomNumbers)->pluck('id')->toArray();

            if (count($roomIds) !== count($roomNumbers)) {
                throw new ModelNotFoundException('One or more room numbers were not found.');
            }

            $offer->rooms()->sync($roomIds);

            return $this->Success(OfferResource::make($offer), 'Offer updated successfully');

        } catch (ModelNotFoundException $e) {
            throw new BusinessLogicException('One or more room numbers were not found');
        } catch (\Exception $e) {
            throw new BusinessLogicException('Unexpected error while updating the offer: ' . $e->getMessage());
        }
    }
}
