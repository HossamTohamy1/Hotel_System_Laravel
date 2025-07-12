<?php

namespace App\Http\Requests\RoomRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'room_type' => 'required|string',
            'room_number' => 'required|string',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|integer',
            'description' => 'nullable|text',
            'imagePath' => 'nullable|string',
            'available' => 'boolean',
        ];
    }
}
