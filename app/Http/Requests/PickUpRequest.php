<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => ['required', 'integer'],
            'parking_id' => ['required', 'integer'],
            'car_type' => ['required', 'string', 'max:255'],
            'start_parking' => ['required', 'date'],
            'end_parking' => ['required', 'date','after:start_parking']
        ];
    }
}
