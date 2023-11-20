<?php

namespace App\Transformers;
use Carbon\Carbon;

class ServiceTransformer extends Transformer
{
    protected $resourceName = 'service';

    public function transform($data)
    {
        return [
            'id' => $data['id'],
            'date' => Carbon::parse($data['date'])->format('d/m/Y'),
            'flight_number' => $data['flight_number'],
            'door' => $data['door'],
            'origin' => $data['origin']['name'],
            'destiny' => $data['destiny']['name'],
            'hour' => $data['hour'],
            'seat' => $data['seat'],
            'weight' => $data['weight'],
            'quantity' => $data['quantity'],
            'ticket' => $data['ticket'],
            'total' => $data['total'],
            'age' => $data['age']['description'],
            'passenger_name' => $data['passenger']['names'],
            'passenger_ci' => $data['passenger']['ci'],
        ];
    }
}