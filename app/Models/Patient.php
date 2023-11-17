<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'names', 'surnames', 'ci', 'phone', 'birth'
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
