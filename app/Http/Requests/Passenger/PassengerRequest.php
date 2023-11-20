<?php

namespace App\Http\Requests\Passenger;

use Illuminate\Foundation\Http\FormRequest;

class PassengerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'names' => 'required|max:128|min:3',
            'ci' => 'required|max:10|min:1|unique:passengers',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'names' => 'nombre completo',
            'ci' => 'ci',
        ];
    }
}
