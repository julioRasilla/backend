<?php

namespace App\Traits;

trait ApiFormatTrait
{
    /**
     * Genera una respuesta JSON para un recurso no encontrado.
     *
     * @param int $code Código de error.
     * @param string $message Descripción del error.
     * @return array Arreglo con los detalles del error.
     */
    protected function errorArray($code, $message)
    {
        return [
            "details" => [
                "code" => $code,
                "description" => $message
            ]
        ];
    }
}
