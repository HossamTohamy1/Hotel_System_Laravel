<?php

namespace App\Http\Requests\RoomRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'room_type' => 'sometimes|required|string',
            'room_number' => 'sometimes|required|string',
            'price_per_night' => 'sometimes|required|numeric',
            'capacity' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'imagePath' => 'nullable|string',
            'available' => 'sometimes|boolean',
        ];
    }
}
