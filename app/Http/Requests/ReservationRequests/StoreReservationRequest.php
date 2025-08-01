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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'           => 'required|exists:users,id',
            'room_id'           => 'required|exists:rooms,id',
            'offer_id'          => 'nullable|exists:offers,id',
            'check_in_date'     => 'required|date|after_or_equal:today',
            'check_out_date'    => 'required|date|after:check_in_date',
            'number_of_guests'  => 'nullable|integer|min:1',
            'total_amount'      => 'nullable|numeric|min:0',
            'status'            => 'in:pending,confirmed,cancelled,completed',
        ];
    }
}
