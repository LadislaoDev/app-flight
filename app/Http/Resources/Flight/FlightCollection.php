<?php

namespace App\Http\Resources\Flight;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Flight\FlightResource;

class FlightCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($flight){
            return new FlightResource($flight);
        });
    }
}
