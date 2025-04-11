<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource para transformar el modelo Empleado a formato JSON.
 *
 * Proporciona una representación estructurada de los datos del empleado
 * para respuestas API, incluyendo mapeo de campos y formato consistente.
 */
class EmpleadoResource extends JsonResource
{
    /**
     * Transforma el recurso en un array.
     *
     * @param  Request  $request  La instancia actual de la solicitud HTTP
     * @return array<string, mixed>  Array con la representación del empleado
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidoPaterno' => $this->apellido_paterno,
            'apellidoMaterno' => $this->apellido_materno,
            'telefono' => $this->telefono,
            'telefonoCelular' => $this->telefono_celular,
            'activo' => $this->activo,
        ];        
    }
}