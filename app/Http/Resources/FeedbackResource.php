<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? null,
            ],
            'reservation_id' => $this->reservation_id,
            'rating' => $this->rating,
            'comments' => $this->comments,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
