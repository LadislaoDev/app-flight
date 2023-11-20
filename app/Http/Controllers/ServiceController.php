<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Transformers\ServiceTransformer;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private $service;

    protected $transformer;

    public function __construct(Service $service, ServiceTransformer $transformer)
    {
        $this->service = $service;

        $this->transformer = $transformer;
    }

    public function create(Request $request)
    {
        $service = $this->service->create([
            'date' =>  $request->date, 
            'flight_number' =>  $request->flight_number,
            'door' =>  $request->door,
            'origin_id' =>  $request->origin,
            'destiny_id' =>  $request->destiny,
            'hour' =>  $request->hour,
            'seat' =>  $request->seat,
            'weight' =>  $request->weight,
            'quantity' =>  $request->quantity,
            'ticket' =>  $request->ticket,
            'total' =>  $request->total,
            'age_id' =>  $request->age_id,
            'passenger_id' =>  $request->passenger_id
        ]);

        DB::table('places')->where('id', $request->seat_id)->update(['state' => 1, 'disabled' => 1]);

        return response()->json(['success' => true, 'data' => $service], 200);
    }

    public function generatePDF(Service $service)
    {
        $data = $this->transformer->item($service);

        $export = new PdfExport('boarding.pass', ['service' => $data['service']]);
        return $export->setMargin(2,2,2,2)->download();
    }
}
