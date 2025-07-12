<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id'         => $this->id,
            'name'      => $this->name,
             'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'discount'   => $this->discount,
            'rooms'      => RoomResource::collection(resource: $this->whenLoaded('rooms')),
            'created_at' => $this->created_at,
        ];
    }
}
