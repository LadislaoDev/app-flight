<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\Service\ServiceCreateRequest;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function create(ServiceCreateRequest $request)
    {
        // Obtener el mes actual
        $mesActual = Carbon::now()->month;

        $errores = [];

        // Buscar todos los servicios del mes actual para el paciente
        $serviciosDelMes = $this->service->where('patient_id', $request->service['patient_id'])
                                        ->whereMonth('date', $mesActual)
                                        ->get();

        // Verificar si alguno de los servicios ya tiene algún benefit_id en su tabla pivote
        foreach ($serviciosDelMes as $servicio) {
            foreach ($request->benefits as $key => $value) {
                $existeRegistro = $this->verificarRegistroExistente($servicio->id, $value['benefit_id']);
    
                // if ($existeRegistro) {
                //     // Obtener el nombre del beneficio
                //     $nombreBeneficio = $this->obtenerNombreBeneficio($value['benefit_id']);
    
                //     $errores[] = "El beneficio '$nombreBeneficio' del item " . ($key + 1) . " ya se registro para el paciente en el mes actual.";
                // }

                if ($existeRegistro) {
                    // Verificar si han pasado menos de 30 días desde el último registro
                    $fechaUltimoRegistro = $this->obtenerFechaUltimoRegistro($servicio->id, $value['benefit_id']);
    
                    if ($fechaUltimoRegistro && Carbon::now()->diffInDays($fechaUltimoRegistro) < 30) {
                        $rest = 30 - Carbon::now()->diffInDays($fechaUltimoRegistro);
                        // Obtener el nombre del beneficio
                        $nombreBeneficio = $this->obtenerNombreBeneficio($value['benefit_id']);
    
                        // Almacenar el error en el array
                        $errores[] = "El beneficio '$nombreBeneficio' del item " . ($key + 1) . " ya fue registrado en el mes actual, registro en 30 días. (restantes: $rest Días)";
                    }
                }
            }
        }

        // Si hay errores, devolver el array de errores
        if (!empty($errores)) {
            return response()->json(['errors' => $errores], 406);
        }

        $service = $this->service->create([
            'description' => $request->service['description'],
            'patient_id' => $request->service['patient_id'],
            'hospital_id' => $request->service['hospital_id'],
            'user_id' => $request->user()->id,
            'date' => $request->service['date'],
        ]);

        foreach ($request->benefits as $key => $value) {
            $service->benefits()->attach($value['benefit_id'], [
                'quantity' => $value['quantity'], 
                'observation' => $value['observation'], 
            ]);
        }

        return response()->json(['success' => true, 'data' => $service], 200);
    }

    private function verificarRegistroExistente($serviceId, $benefitId)
    {
        return DB::table('benefit_service')
        ->where('service_id', $serviceId)
        ->where('benefit_id', $benefitId)
        ->exists();
    }

    private function obtenerNombreBeneficio($benefitId)
    {
        return DB::table('benefits')
            ->where('id', $benefitId)
            ->value('name');
    }

    private function obtenerFechaUltimoRegistro($serviceId, $benefitId)
    {
    return DB::table('benefit_service')
        ->where('service_id', $serviceId)
        ->where('benefit_id', $benefitId)
        ->latest('created_at')
        ->value('created_at');
    }
}
