<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar operaciones que requieren un ID como entrada.
 * 
 * Proporciona validación básica para identificadores, incluyendo:
 * - Inyección del ID desde la ruta
 * - Validación de tipo y valor mínimo
 * - Mensajes de error personalizados
 */
class IdInputRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * 
     * @return bool Siempre devuelve true, permitiendo el acceso a todos los usuarios
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepara los datos para validación incluyendo el ID de la ruta.
     * 
     * @return array Datos de la solicitud con el ID inyectado desde la ruta
     */
    public function validationData(): array
    {
        $data = parent::validationData();
        $data['id'] = $this->route('id');
        return $data;
    }

    /**
     * Define las reglas de validación para el ID.
     * 
     * @return array<string, string> Reglas de validación para el campo ID
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1',
        ];
    }

    /**
     * Proporciona mensajes de error personalizados para las reglas de validación.
     * 
     * @return array<string, string> Mensajes personalizados para cada caso de error
     */
    public function messages(): array
    {
        return [
            'id.required' => 'El campo ID es obligatorio.',
            'id.integer' => 'El ID debe ser un número entero.',
            'id.min' => 'El ID debe ser mayor que 0.',
        ];
    }
}