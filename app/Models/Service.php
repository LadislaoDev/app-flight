<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'date', 'flight_number', 'door', 'origin_id', 'destiny_id', 'hour', 'seat', 'weight', 'quantity', 'ticket', 'total', 'age_id', 'passenger_id'
    ];

    public function origin()
    {
        return $this->belongsTo(City::class);
    }

    public function destiny()
    {
        return $this->belongsTo(City::class);
    }
    
    public function age()
    {
        return $this->belongsTo(Age::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }
}
