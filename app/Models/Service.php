<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'date', 'door', 'seat', 'weight', 'quantity', 'ticket', 'total', 'place_id', 'age_id', 'passenger_id', 'flight_id'
    ];

    // public function origin()
    // {
    //     return $this->belongsTo(City::class);
    // }

    // public function destiny()
    // {
    //     return $this->belongsTo(City::class);
    // }
    
    public function age()
    {
        return $this->belongsTo(Age::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
