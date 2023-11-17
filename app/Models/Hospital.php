<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address'
    ];

    public static function listHospitals()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name', 'address')->get();
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
