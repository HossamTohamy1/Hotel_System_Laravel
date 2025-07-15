<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'offer_id' => $this->offer_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'number_of_guests' => $this->number_of_guests,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
