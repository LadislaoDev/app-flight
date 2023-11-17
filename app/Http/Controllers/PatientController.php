<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\Patient\PatientCreateRequest;
use App\Http\Resources\Patient\PatientCollection;

class PatientController extends Controller
{
    private $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function search(Request $request)
    {
        $ci = $request->input('ci');
        $patients = $this->patient->where('ci', 'LIKE', "%$ci%")->get();

        return new PatientCollection($patients);
    }

    public function searchPatient(Request $request)
    {
        $ci = $request->input('ci');
        if ($ci != "") {
            $patients = $this->patient->where('ci', 'LIKE', "%$ci%")->get();

            return response()->json(['data' => $patients]);
        }

        return response()->json(['data' => []]);
    }

    public function create(PatientCreateRequest $request)
    {
        $patient = $this->patient->create($request->all());
        return response()->json(['success' => true, 'data' => $patient], 200);
    }
}
