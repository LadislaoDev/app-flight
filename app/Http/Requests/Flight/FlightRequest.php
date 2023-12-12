<?php

namespace App\Http\Requests\Flight;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'number' => 'required|max:64|unique:flights,number',
            'date' => 'required|date_format:Y-m-d',
            'origin' => 'required|integer',
            'destiny' => 'required|integer',
            'hour' => 'required',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['number'] .= ',' . $this->flight->id;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'number' => 'n° vuelo',
            'date' => 'fecha',
            'origin' => 'origen',
            'destiny' => 'destino',
            'hour' => 'hora',
        ];
    }
}
