<?php

namespace App\Logging;

/**
 * Interfaz que define el contrato para las estrategias de almacenamiento de bitácora
 * 
 * Esta interfaz establece el método obligatorio que deben implementar todas las clases
 * que proporcionen diferentes formas de almacenar registros de bitácora (logs de auditoría).
 * 
 * Implementa el patrón Strategy permitiendo intercambiar dinámicamente entre diferentes
 * métodos de almacenamiento (archivos, base de datos, servicios externos, etc.).
 * 
 * @package App\Logging
 */
interface BitacoraEstrategia
{
    /**
     * Método principal para almacenar registros de bitácora
     * 
     * Todas las implementaciones deben proporcionar esta funcionalidad básica
     * para persistir los datos de auditoría según su estrategia específica.
     *
     * @param array $datos Estructura de datos a registrar. Debe contener:
     *              - idUsuario (int): Identificador del usuario
     *              - usuario (string): Nombre del usuario
     *              - ipUsuario (string): Dirección IP
     *              - funcionalidad (string): Módulo/feature accedido
     *              - accion (string): Tipo de operación (GET, POST, etc.)
     *              - datos (mixed): Información adicional relevante
     *              - fechaHoraCreacion (string): Timestamp opcional
     * @return void
     * 
     * @example
     * <pre>
     * $estrategia->guardar([
     *     'idUsuario' => 42,
     *     'usuario' => 'jperez',
     *     'ipUsuario' => '192.168.1.100',
     *     'funcionalidad' => 'login',
     *     'accion' => 'POST',
     *     'datos' => ['dispositivo' => 'mobile']
     * ]);
     * </pre>
     */
    public function guardar(array $datos): void;
}