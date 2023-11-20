<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PassengerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'names' => $this->names,
            'ci' => $this->ci,
        ];
    }
}
