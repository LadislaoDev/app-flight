<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\Service\ServiceRequest;
use App\Exports\PdfExport;
use App\Transformers\ServiceTransformer;
use App\Http\Resources\Service\ServiceManifestCollection;
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

    public function create(ServiceRequest $request)
    {
        $service = $this->service->create([
            'date' =>  $request->date, 
            'door' =>  $request->door,
            'seat' =>  $request->seat,
            'weight' =>  $request->weight,
            'quantity' =>  $request->quantity,
            'ticket' =>  $request->ticket,
            'total' =>  $request->total,
            'place_id' =>  $request->place_id,
            'age_id' =>  $request->age_id,
            'passenger_id' =>  $request->passenger_id,
            'flight_id' =>  $request->flight_id
        ]);

        DB::table('places')->where('id', $request->place_id)->update(['state' => 1, 'disabled' => 1]);

        return response()->json(['success' => true, 'data' => $service], 200);
    }

    public function generatePDF(Service $service)
    {
        $data = $this->transformer->item($service);

        $export = new PdfExport('boarding.pass', ['service' => $data['service']]);
        return $export->setMargin(2,2,2,2)->download();
    }

    public function getCheckinManifest(Request $request)
    {
        $services = $this->service->whereHas('flight', function ($query) use ($request) {
            $query->where('number', $request->flight_number);
        })
        ->where('date', $request->date)
        ->get();
        return new ServiceManifestCollection($services);
    }
}
