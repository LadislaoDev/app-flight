<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Passenger\PassengerResource;

class PassengerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($passenger){
            return new PassengerResource($passenger);
        });
    }
}
