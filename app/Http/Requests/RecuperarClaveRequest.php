<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecuperarClaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario' => 'required|email|exists:usuarios,usuario'
        ];
    }

    public function messages(): array
    {
        return [
            'usuario.exists' => 'El correo proporcionado no está registrado en nuestro sistema.'
        ];
    }
}