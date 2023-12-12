<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:64|unique:users,name',
            'email' => 'required|email|max:64|unique:users,email',
            'city_id' => 'required|integer',
            'rol' => 'required',
        ];

        if($this->method() == 'POST') {
            $rules['password'] = 'required|min:5';
            $rules['password_confirmation'] = 'required|min:5|same:password';
        }

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->user->id;
            $rules['email'] .= ',' . $this->user->id;
            $rules['password'] = 'nullable|min:5';
            $rules['password_confirmation'] = 'nullable|min:5|same:password';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'nombre usuario',
            'email' => 'correo electrónico',
            'rol' => 'tipo usuario',
            'city_id' => 'ciudad',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación contraseña',
        ];
    }
}
