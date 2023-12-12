<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'date' => 'required|date_format:Y-m-d',
            // 'flight_number' => 'required|max:64',
            'passenger_id' => 'required|integer',
            'ci' => 'required|max:64',
            'door' => 'required|integer',
            // 'origin' => 'required|integer',
            // 'destiny' => 'required|integer',
            // 'hour' => 'required',
            'seat' => 'required',
            'weight' => 'required|integer',
            'quantity' => 'required|integer',
            'ticket' => 'required|max:32',
            'total' => 'required|integer',
            'age_id' => 'required|integer',
            'flight_id' => 'required|integer',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'date' => 'fecha',
            // 'flight_number' => 'n° vuelo',
            'passenger_id' => 'pasajero',
            'door' => 'puerta',
            // 'origin' => 'origen',
            // 'destiny' => 'destino',
            // 'hour' => 'hora',
            'seat' => 'asiento',
            'weight' => 'peso aprox.',
            'quantity' => 'cantidad',
            'ticket' => 'ticket',
            'total' => 'total',
            'age_id' => 'edad',
            'flight_id' => 'n° de vuelo',
        ];
    }
}
