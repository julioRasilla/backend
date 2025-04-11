<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'idTipoUsuario' => $this->id_tipo_usuario,
            'idPerfil' => $this->id_perfil,
            'idEmpleado' => $this->id_empleado,
            'idCliente' => $this->id_cliente,
            'usuario' => $this->usuario,
            'activo' => $this->activo,
        ];

        // Si tiene empleado relacionado, cargar esos datos
        if ($this->id_empleado && $this->relationLoaded('empleado')) {
            $response['empleado'] = [
                'id' => $this->id,
                'nombre' => $this->empleado->nombre,
                'apellidoPaterno' => $this->empleado->apellido_paterno,
                'apellidoMaterno' => $this->empleado->apellido_materno,
                'activo' => $this->activo,
            ];
        }

        // Si tiene cliente relacionado, cargar esos datos
        if ($this->id_cliente && $this->relationLoaded('cliente')) {
            $response['cliente'] = new ClienteResource($this->cliente);
        }

        return $response;
    }
}
