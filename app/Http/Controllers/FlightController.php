<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Flight\FlightRequest;
use App\Http\Resources\Flight\FlightCollection;
use Illuminate\Support\Facades\DB;

class FlightController extends Controller
{
    private $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    public function index(Request $request)
    {
        $flights = $this->flight->orderBy('created_at', $request->sort)->paginate($request->per_page);
        return new FlightCollection($flights);
    }

    public function register(FlightRequest $request)
    {
        $flight = $this->flight->create([
            'number' => $request->number,
            'date' => $request->date,
            'origin_id' => $request->origin,
            'destiny_id' => $request->destiny,
            'hour' => $request->hour,
        ]);
        
        return response()->json(['success' => true, 'data' => $flight], 200);
    }

    public function update(FlightRequest $request, Flight $flight)
    {
        $model = $this->flight->find($flight->id);

        $model->number = $request->number;
        $model->date = $request->date;
        $model->origin_id = $request->origin;
        $model->destiny_id = $request->destiny;
        $model->hour = $request->hour;

        $model->save();

        return response()->json(['success' => true, 'data' => $model], 200);
    }

    public function delete(Flight $flight)
    {
        $flight->delete();

        return response()->json(['success' => true], 200);
    }

    public function complete(Flight $flight)
    {
        DB::beginTransaction();

        try {
            $services = DB::table('services')->where('flight_id', $flight->id)->get();

            foreach ($services as $key => $item) {
                DB::table('places')->where('id', $item->place_id)->update(['state' => 0, 'disabled' => 0]);
            }

            $flight->state = 1;
            $flight->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false], 500);
        }

        return response()->json(['success' => true], 200);
    }

    public function search(Request $request)
    {
        $number = $request->input('number');
        if ($number != "") {
            $flights = $this->flight->where('number', 'LIKE', "%$number%")->get();

            return response()->json(['data' => $flights]);
        }

        return response()->json(['data' => []]);
    }
}
