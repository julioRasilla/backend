<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;


/**
 * Implementación de estrategia para guardar registros de bitácora en archivos
 * 
 * Esta clase implementa la interfaz BitacoraEstrategia para el almacenamiento
 * de registros de auditoría en archivos de log del sistema.
 * 
 * Características principales:
 * - Utiliza el canal 'bitacora' configurado en Laravel
 * - Formatea los datos como JSON legible
 * - Soporte para caracteres Unicode
 * - Implementa el patrón Strategy para bitácoras
 */
class BitacoraArchivo implements BitacoraEstrategia
{
    /**
     * Guarda un registro de auditoría en el archivo de log
     * 
     * Proceso:
     * 1. Recibe un array asociativo con los datos a registrar
     * 2. Convierte los datos a JSON formateado
     * 3. Escribe en el canal específico de bitácora
     * 
     * @param array $datos Datos estructurados a registrar. Debe contener:
     *              - fechaHoraCreacion (timestamp)
     *              - idUsuario (int)
     *              - ipUsuario (string)
     *              - usuario (string)
     *              - funcionalidad (string)
     *              - accion (string)
     *              - datos (array|string)
     * @return void
     * 
     * @example
     * <pre>
     * $datos = [
     *     'fechaHoraCreacion' => '2023-05-15 14:30:00',
     *     'idUsuario' => 1,
     *     'ipUsuario' => '192.168.1.1',
     *     // ... otros campos
     * ];
     * $bitacora->guardar($datos);
     * </pre>
     */
    public function guardar(array $datos): void
    {
        Log::channel('bitacora')->info(json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}