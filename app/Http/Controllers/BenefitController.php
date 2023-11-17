<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    private $benefit;

    public function __construct(Benefit $benefit)
    {
        $this->benefit = $benefit;
    }

    public function listBenefits()
    {
        $benefits = $this->benefit->listBenefits();
        return response()->json(['data' => $benefits]);
    }
}
