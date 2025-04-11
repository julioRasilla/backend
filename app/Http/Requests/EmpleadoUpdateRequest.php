<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al actualizar un empleado.
 *
 * Define las reglas de validación para los campos relacionados con un empleado
 * cuando se realiza una operación de actualización, incluyendo la validación del ID.
 */
class EmpleadoUpdateRequest extends FormRequest
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
     * Define las reglas de validación para los campos del empleado en actualización.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * Retorna un array con las reglas de validación para cada campo.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1',
            'nombre' => 'required|string|max:30',
            'apellidoPaterno' => 'required|string|max:30',
            'apellidoMaterno' => 'nullable|string|max:30',
            'telefono' => 'nullable|digits:10',
            'telefonoCelular' => 'nullable|digits:10',
        ];
    }

    /**
     * Prepara los datos para validación, incluyendo el ID de la ruta.
     *
     * @return array Devuelve los datos de la solicitud con el ID incluido.
     */
    public function validationData()
    {
        $data = $this->all();
        $data['id'] = $this->route('id');
        return $data;
    }
}