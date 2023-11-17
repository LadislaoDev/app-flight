<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'names' => 'required|max:128|min:3',
            'surnames' => 'required|max:128|min:3',
            'ci' => 'required|max:10|min:1|unique:patients',
            'phone' => 'required|max:16',
            'birth' => 'required|date',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'names' => 'nombre(s)',
            'surnames' => 'apellido(s)',
            'ci' => 'ci',
            'phone' => 'teléfono',
            'birth' => 'nacimiento',
        ];
    }
}
