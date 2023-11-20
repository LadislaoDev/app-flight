<?php

namespace App\Http\Resources\Type;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'row' => $this->row,
            'column' => $this->column,
            // 'phone' => $this->phone ? $this->phone : 'S/D',
            // 'birth' => Carbon::parse($this->birth)->format('d/m/Y'),
            // 'total_services' => $this->services()->whereMonth('date', Carbon::now()->month)->count(),
            'places' => collect($this->places)->transform(function($place) {
                return [
                    'id' => $place->id,
                    'number' => $place->number,
                    'order' => $place->order,
                    'state' => $place->state,
                    'disabled' => $place->disabled
                ];
            })
        ];
    }
}
