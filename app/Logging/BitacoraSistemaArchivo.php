<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;

/**
 * Implementación de la estrategia para almacenar la bitácora en un archivo.
 */
class BitacoraSistemaArchivo implements BitacoraSistemaEstrategia
{
    /**
     * Guarda un registro en el archivo de bitácora.
     *
     * @param array $datos Datos a registrar en la bitácora.
     */
    public function guardar(array $datos): void
    {
        Log::channel('bitacora_sistema')->info(json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
