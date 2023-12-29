<?php

namespace App\Transformers;
use Carbon\Carbon;

class ServiceTransformer extends Transformer
{
    protected $resourceName = 'service';

    public function transform($data)
    {
        switch ($data['age']['description']) {
            case 'ADULTOS':
                $kg = 80;
                break;
            case 'MENORES':
                $kg = 40;
                break;
            case 'INFANTE':
                $kg = 20;
                break;
            default:
                $kg = 80;
        };

        return [
            'id' => $data['id'],
            'date' => Carbon::parse($data['date'])->format('d/m/Y'),
            'flight_number' => $data['flight']['number'],
            'door' => $data['door'],
            'origin' => $data['flight']['origin']['name'],
            'destiny' => $data['flight']['destiny']['name'],
            'hour' => $data['flight']['hour'],
            'seat' => $data['seat'],
            'kg' => $kg,
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