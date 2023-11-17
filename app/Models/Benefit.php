<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function listBenefits()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }
}
