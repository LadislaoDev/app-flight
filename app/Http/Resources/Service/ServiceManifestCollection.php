<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ServiceManifestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($service) {

            switch ($service->age->description) {
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
                'id' => $service->id,
                'date' => Carbon::parse($service->flight->date)->format('d/m/Y'),
                'flight_number' => $service->flight->number,
                'door' => $service->door,
                'origin' => $service->flight->origin->name,
                'destiny' => $service->flight->destiny->name,
                'hour' => $service->flight->hour,
                'seat' => $service->seat,
                'weight' => $service->weight,
                'kg' => $kg,
                'quantity' => $service->quantity,
                'ticket' => $service->ticket,
                'total' => $service->total,
                'age' => $service->age->description,
                'passenger' => $service->passenger,
            ];
        });
    }
}
