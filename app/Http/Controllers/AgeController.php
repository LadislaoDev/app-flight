<?php

namespace App\Http\Controllers;

use App\Models\Age;
use Illuminate\Http\Request;

class AgeController extends Controller
{
    private $age;

    public function __construct(Age $age)
    {
        $this->age = $age;
    }

    public function listAges()
    {
        $ages = $this->age->listAges();
        return response()->json(['data' => $ages]);
    }
}
