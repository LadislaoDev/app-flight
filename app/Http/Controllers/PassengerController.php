<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use App\Http\Requests\Passenger\PassengerRequest;
use App\Http\Resources\Passenger\PassengerCollection;

class PassengerController extends Controller
{
    private $passenger;

    public function __construct(Passenger $passenger)
    {
        $this->passenger = $passenger;
    }

    public function search(Request $request)
    {
        $ci = $request->input('ci');
        if ($ci != "") {
            $passengers = $this->passenger->where('ci', 'LIKE', "%$ci%")->get();

            return response()->json(['data' => $passengers]);
        }

        return response()->json(['data' => []]);
    }

    public function create(PassengerRequest $request)
    {
        $passenger = $this->passenger->create($request->all());
        return response()->json(['success' => true, 'data' => $passenger], 200);
    }
}
