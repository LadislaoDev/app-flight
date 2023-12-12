<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'city' => $this->city->name,
            'city_id' => $this->city->id,
            'created' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated' => Carbon::parse($this->updated_at)->format('d/m/Y'),
        ];
    }
}
