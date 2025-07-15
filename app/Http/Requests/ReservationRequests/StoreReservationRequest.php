<?php

namespace App\Http\Requests\ReservationRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'        => 'required|exists:users,id',
            'reservation_id' => 'required|exists:reservations,id',
            'rating'         => 'required|integer|min:1|max:5',
            'comments'       => 'nullable|string|max:1000',
        ];
    }
}
