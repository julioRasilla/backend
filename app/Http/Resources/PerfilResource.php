<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Recurso API para la representación de perfiles de usuario.
 * 
 * Transforma el modelo Perfil y sus relaciones en un formato JSON estructurado
 * para consumo en APIs. Incluye los datos básicos del perfil y una colección
 * de privilegios asociados cuando están cargados.
 *
 * @property int $id Identificador único del perfil
 * @property string $nombre Nombre descriptivo del perfil
 * @property bool $activo Estado de activación del perfil
 * @property \Illuminate\Database\Eloquent\Collection $privilegios Colección de privilegios asociados
 */
class PerfilResource extends JsonResource
{
    /**
     * Transforma el recurso perfil en un array asociativo para respuesta API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'activo' => $this->activo,
            'privilegios' => PrivilegioResource::collection($this->whenLoaded('privilegios'))
        ];
    }
}