<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Recurso JSON para la representación de privilegios.
 *
 * Esta clase transforma el modelo de Privilegio y sus relaciones
 * en una estructura JSON adecuada para respuestas API.
 * 
 * @property int $id Identificador único del privilegio
 * @property int $id_perfil ID del perfil asociado al privilegio
 * @property int $id_menu ID del menú o funcionalidad asociada al privilegio
 */
class PrivilegioResource extends JsonResource
{
    /**
     * Transforma el recurso en un arreglo JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'idPerfil' => $this->id_perfil,
            'idMenu' => $this->id_menu,
        ];
    }
}