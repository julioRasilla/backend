<?php

namespace App\Helpers;

use App\Logging\BitacoraArchivo;
use App\Logging\BitacoraBaseDatos;
use Illuminate\Support\Facades\Config;

/**
 * Clase helper para el registro de actividades en bitácora
 * 
 * Proporciona un sistema flexible para registrar operaciones que puede almacenar
 * en archivos o base de datos según configuración.
 */
class LogOperacionHelper
{
    /**
     * @var BitacoraArchivo|BitacoraBaseDatos Estrategia de almacenamiento actual
     */
    protected static $estrategia;

    /**
     * Configura la estrategia de almacenamiento de la bitácora basada en configuración
     * 
     * Lee la configuración 'bitacora.storage' (por defecto 'file') para determinar
     * si los registros se guardarán en archivo o base de datos.
     * 
     * @return void
     */
    public static function inicializar()
    {
        $storage = Config::get('bitacora.storage', 'file');

        if ($storage === 'database') {
            self::$estrategia = new BitacoraBaseDatos();
        } else {
            self::$estrategia = new BitacoraArchivo();
        }
    }

    /**
     * Registra una operación en la bitácora con información contextual
     * 
     * Captura automáticamente información de la solicitud HTTP como IP, ruta,
     * método HTTP y combina con los datos proporcionados para crear un registro
     * completo de la operación.
     *
     * @param int $idUsuario ID del usuario que realiza la acción
     * @param string $usuario Nombre del usuario que realiza la acción
     * @param array|string|object $datos Datos adicionales de la operación
     *        (serán convertidos a JSON si no son string)
     * @throws \RuntimeException Si no se puede inicializar la estrategia de almacenamiento
     * @return void
     */
    public static function registrar($idUsuario, $usuario, $datos)
    {
        if (!self::$estrategia) {
            self::inicializar();
        }

        $idUsuario = $idUsuario;
        $ipUsuario = request()->ip();
        $usuario = $usuario;
        $funcionalidad = request()->route() ? request()->route()->getName() : 'desconocido';
        $accion = request()->getMethod();

        $datosJson = is_array($datos) || is_object($datos) 
            ? json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) 
            : $datos;

        $registro = [
            'idUsuario' => $idUsuario,
            'ipUsuario' => $ipUsuario,
            'usuario' => $usuario,
            'funcionalidad' => $funcionalidad,
            'accion' => $accion,
            'datos' => $datosJson,
            'fechaHoraCreacion' => now()->toDateTimeString()
        ];

        self::$estrategia->guardar($registro);
    }
}