<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'names' => $this->names,
            'surnames' => $this->surnames,
            'ci' => $this->ci,
            'phone' => $this->phone ? $this->phone : 'S/D',
            'birth' => Carbon::parse($this->birth)->format('d/m/Y'),
            'total_services' => $this->services()->whereMonth('date', Carbon::now()->month)->count(),
            'services' => collect($this->services()->whereMonth('date', Carbon::now()->month)->get())->transform(function($service) {
                return [
                    'id' => $service->id,
                    'description' => $service->description ? $service->description : 'SIN DETALLES',
                    'hospital' => $service->hospital->name,
                    'user' => $service->user->name,
                    'date' => Carbon::parse($service->date)->format('d/m/Y'),
                    'benefits' => collect($service->benefits)->transform(function($benefit) {
                        return [
                            'id' => $benefit->id,
                            'name' => $benefit->name,
                            'quantity' => $benefit->pivot->quantity,
                            'observation' => $benefit->pivot->observation ? $benefit->pivot->observation : 'SIN DETALLES'
                        ];
                    })
                ];
            })
        ];
    }
}
