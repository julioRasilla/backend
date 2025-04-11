<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al almacenar un empleado.
 * 
 * Define las reglas de validación para los campos relacionados con un empleado
 * cuando se realiza una operación de almacenamiento.
 */
class EmpleadoStoreRequest extends FormRequest
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
     * Define las reglas de validación para los campos del empleado.
     * 
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> 
     * Retorna un array con las reglas de validación para cada campo.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:30',
            'apellidoPaterno' => 'required|string|max:30',
            'apellidoMaterno' => 'nullable|string|max:30',
            'telefono' => 'nullable|digits:10',
            'telefonoCelular' => 'nullable|digits:10',
        ];
    }
}