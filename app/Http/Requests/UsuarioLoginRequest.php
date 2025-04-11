<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al almacenar un usuario.
 * 
 * Define las reglas de validación para los campos relacionados con un usuario
 * cuando se realiza una operación de almacenamiento.
 */
class UsuarioLoginRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * 
     * @return bool Devuelve true para indicar que todos los usuarios están autorizados.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define las reglas de validación para los campos del usuario.
     * 
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> 
     * Retorna un array con las reglas de validación para cada campo.
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required|string',
            'clave' => 'required|string',            
        ];
    }
}