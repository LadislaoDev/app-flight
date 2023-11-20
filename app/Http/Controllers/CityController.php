<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $citie;

    public function __construct(City $citie)
    {
        $this->citie = $citie;
    }

    public function listCities()
    {
        $cities = $this->citie->listCities();
        return response()->json(['data' => $cities]);
    }
}
