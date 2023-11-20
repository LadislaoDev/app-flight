<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }
}
