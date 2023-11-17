<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'service.patient_id' => 'required|integer',
            'service.hospital_id' => 'required|integer',
            'service.date' => 'required|date',
            'service.description' => 'nullable|max:128',
            'benefits' => 'required|array',
            'benefits.*.benefit_id' => 'required|integer',
            'benefits.*.quantity' => 'required|integer',
            'benefits.*.description' => 'nullable|max:63',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'service.patient_id' => 'paciente',
            'service.hospital_id' => 'hospital',
            'service.date' => 'fecha',
            'service.description' => 'descripción',
            'benefits' => 'beneficios'
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->benefits as $key => $value){
            $item = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT) + 1;
            $messages['benefits.'. $key .'.benefit_id.required'] = 'El campo beneficio del item '. $item .' es requerido.';
            $messages['benefits.'. $key .'.quantity.required'] = 'El campo cantidad del item '. $item .' es requerido.';
            $messages['benefits.'. $key .'.description.max'] = 'El campo descripión del item '. $item .' no debe ser mayor a 64 caracteres.';
        }
        return $messages;
    }
}
