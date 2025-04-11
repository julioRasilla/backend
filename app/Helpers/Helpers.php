<?php

use App\Helpers\LogOperacionHelper;

if (!function_exists('LogOperacion')) {
    /**
     * Función helper global para registrar operaciones
     * 
     * @param int $idUsuario ID del usuario
     * @param string $usuario Nombre del usuario
     * @param mixed $datos Datos adicionales de la operación
     */
    function LogOperacion($idUsuario, $usuario, $datos)
    {
        return LogOperacionHelper::registrar($idUsuario, $usuario, $datos);
    }
}