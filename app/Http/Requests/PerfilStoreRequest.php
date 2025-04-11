<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al almacenar un perfil.
 * 
 * Define las reglas de validación para los campos relacionados con un perfil
 * cuando se realiza una operación de almacenamiento.
 */
class PerfilStoreRequest extends FormRequest
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
     * Define las reglas de validación para los campos del perfil.
     * 
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> 
     * Retorna un array con las reglas de validación para cada campo.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:30',
            'activo' => 'boolean',
            'privilegios' => 'required|array|min:1',
            'privilegios.*.idPrivilegio' => 'required|integer|exists:menus,id'
        ];
    }
}