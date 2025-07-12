<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "room_type"=> $this->room_type,
            "room_number"=> $this->room_number,
            "capacity"=> $this->capacity,
            "description"=> $this->description,
            "imagePath"=> $this->imagePath,
            "available"=> $this->available,
        ];
    }
}
