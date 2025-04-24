<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarClaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario' => 'required|email|exists:usuarios,usuario',
            'codigo' => 'required|string|size:6',
            'nueva_clave' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'regex:/^
                    (?=.*[A-Z])  # Al menos 1 mayúscula
                    (?=.*[\#\$\%\@\!\?])  # Al menos 1 carácter especial
                    .*$/x'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nueva_clave.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial (#$%@!?).'
        ];
    }
}