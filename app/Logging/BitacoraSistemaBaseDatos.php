<?php


namespace App\Logging;

use App\Models\BitacoraSistema;

/**
 * Implementación de la estrategia para almacenar la bitácora en la base de datos.
 */
class BitacoraSistemaBaseDatos implements BitacoraSistemaEstrategia
{
    /**
     * Guarda un registro en la base de datos.
     *
     * @param array $datos Datos a registrar en la bitácora.
     */
    public function guardar(array $datos): void
    {        
        BitacoraSistema::create([
            'id_usuario' => $datos['idUsuario'],
            'usuario' => $datos['usuario'],
            'ip' => $datos['ipUsuario'],
            'funcionalidad' => $datos['funcionalidad'],
            'dato' => $datos['dato'],
            'fecha_creacion' => now(),
        ]);
    }
}
