<?php

namespace App\Logging;

/**
 * Interfaz para estrategias de almacenamiento de bitácora
 * 
 * Define el contrato que deben implementar todas las estrategias concretas
 * de almacenamiento de registros de bitácora del sistema.
 */
interface BitacoraSistemaEstrategia
{
    /**
     * Guarda un registro de bitácora en el almacenamiento implementado
     * 
     * @param array $datos Datos estructurados del registro. Debe contener:
     *   - idUsuario (int): Identificador del usuario
     *   - usuario (string): Nombre del usuario
     *   - ipUsuario (string): Dirección IP
     *   - funcionalidad (string): Nombre de la funcionalidad/ruta
     *   - dato (mixed): Información adicional específica
     */
    public function guardar(array $datos): void;
}