<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'patient_id', 'hospital_id', 'user_id', 'date'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class)->withTimestamps()->withPivot('id', 'quantity', 'observation');
    }
}
