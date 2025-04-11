<?php

namespace App\Logging;

use App\Models\BitacoraOperacion;

/**
 * Implementación de estrategia para almacenamiento de bitácora en base de datos
 *
 * Esta clase implementa la interfaz BitacoraEstrategia para guardar registros
 * de auditoría directamente en la base de datos mediante Eloquent.
 *
 * Características principales:
 * - Adapta los nombres de campos de camelCase a snake_case
 * - Registra la fecha/hora actual automáticamente
 * - Utiliza el modelo BitacoraOperacion para persistencia
 * - Implementa el patrón Strategy para bitácoras
 */
class BitacoraBaseDatos implements BitacoraEstrategia
{
    /**
     * Persiste un registro de auditoría en la base de datos
     *
     * Proceso:
     * 1. Recibe datos en formato camelCase
     * 2. Transforma a snake_case para la base de datos
     * 3. Registra timestamp actual
     * 4. Crea nuevo registro mediante Eloquent
     *
     * @param array $datos Datos estructurados a registrar. Debe contener:
     *              - idUsuario (int) -> se convierte a id_usuario
     *              - ipUsuario (string) -> se convierte a ip_usuario
     *              - usuario (string)
     *              - funcionalidad (string)
     *              - accion (string)
     *              - datos (array|string) - se espera JSON
     * @return void
     *
     * @throws \Illuminate\Database\QueryException Si falla la inserción
     *
     * @example
     * <pre>
     * $bitacora->guardar([
     *     'idUsuario' => 1,
     *     'ipUsuario' => '192.168.1.1',
     *     'usuario' => 'admin',
     *     'funcionalidad' => 'login',
     *     'accion' => 'POST',
     *     'datos' => json_encode(['device' => 'mobile'])
     * ]);
     * </pre>
     */
    public function guardar(array $datos): void
    {
        $registro = [
            'fecha_hora_creacion' => now()->toDateTimeString(), // Convertimos a snake_case
            'id_usuario' => $datos['idUsuario'],
            'ip_usuario' => $datos['ipUsuario'],
            'usuario' => $datos['usuario'],
            'funcionalidad' => $datos['funcionalidad'],
            'accion' => $datos['accion'],
            'datos' => $datos['datos'], 
        ];

        BitacoraOperacion::create($registro);
    }
}