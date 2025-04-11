<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al actualizar un perfil.
 *
 * Define las reglas de validación para los campos relacionados con un perfil
 * cuando se realiza una operación de actualización, incluyendo la validación del ID.
 */
class PerfilUpdateRequest extends FormRequest
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
     * Define las reglas de validación para los campos del perfil en actualización.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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