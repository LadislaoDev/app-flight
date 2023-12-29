<?php

namespace App\Http\Resources\Flight;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FlightResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'date_edit' => $this->date,
            'origin' => $this->origin->name,
            'destiny' => $this->destiny->name,
            'origin_id' => $this->origin->id,
            'destiny_id' => $this->destiny->id,
            'state' => $this->state == 0 ? 'PENDIENTE' : 'COMPLETADO',
            'hour' => $this->hour,
            'created' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated' => Carbon::parse($this->updated_at)->format('d/m/Y'),
        ];
    }
}
