<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para validar los datos al actualizar un usuario.
 *
 * Define las reglas de validación para los campos relacionados con un usuario
 * cuando se realiza una operación de actualización, incluyendo la validación del ID.
 */
class UsuarioUpdateRequest extends FormRequest
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
     * Define las reglas de validación para los campos del usuario en actualización.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * Retorna un array con las reglas de validación para cada campo.
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required|string|email|max:255',
            'idTipoUsuario' => 'required|integer',
            'idPerfil' => 'required|integer|exists:perfiles,id',
            'idEmpleado' => [
                'nullable',
                'integer',
                'required_without:idCliente',
                'prohibited_unless:idCliente,null'
            ],
            'idCliente' => [
                'nullable',
                'integer',
                'required_without:idEmpleado',
                'prohibited_unless:idEmpleado,null'
            ],
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