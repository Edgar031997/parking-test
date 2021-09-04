<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required','max:20', 'regex:/^\+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/'],
            'email' => ['required', 'max:255', 'string', 'email:filter',
                Rule::unique('clients')->ignore($request->id)
            ]
        ];
    }
}
