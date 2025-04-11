<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
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
