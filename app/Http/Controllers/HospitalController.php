<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    private $hospital;

    public function __construct(Hospital $hospital)
    {
        $this->hospital = $hospital;
    }

    public function listHospitals()
    {
        $hospitals = $this->hospital->listHospitals();
        return response()->json(['data' => $hospitals]);
    }
}
