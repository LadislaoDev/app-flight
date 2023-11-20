<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public static function listAges()
    {
        return static::orderBy('id', 'DESC')->select('id', 'description')->get();
    }
}
