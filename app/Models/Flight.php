<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'date', 'origin_id', 'destiny_id', 'hour'
    ];

    public function origin()
    {
        return $this->belongsTo(City::class);
    }

    public function destiny()
    {
        return $this->belongsTo(City::class);
    }
}
