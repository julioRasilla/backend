<?php

namespace App\Logging;

use Illuminate\Support\Facades\Auth;

/**
 * Contexto para el registro de bitácora del sistema
 * 
 * Implementa el patrón Strategy para permitir diferentes métodos de almacenamiento.
 * Centraliza el registro de actividades del sistema con información contextual.
 */
class BitacoraSistemaContext
{
    /**
     * @var BitacoraSistemaEstrategia Estrategia de almacenamiento
     */
    protected BitacoraSistemaEstrategia $estrategia;

    /**
     * Constructor - Inicializa con estrategia de almacenamiento
     * 
     * @param BitacoraSistemaEstrategia $estrategia Implementación concreta para guardar registros
     */
    public function __construct(BitacoraSistemaEstrategia $estrategia)
    {
        $this->estrategia = $estrategia;
    }

    /**
     * Registra una operación en la bitácora con datos contextuales
     * 
     * Recoge automáticamente:
     * - ID y nombre de usuario (o valores por defecto si no autenticado)
     * - IP del cliente
     * - Nombre de la ruta actual
     * 
     * @param mixed $dato Datos específicos de la operación a registrar
     */
    public function registrar(mixed $dato): void
    {
        $idUsuario = Auth::id() ?? 1;
        $usuario = Auth::user()?->usuario ?? 'Desconocido';        
        $ip = request()->ip();
        $funcionalidad = request()->route()?->getName() ?? 'Ruta Desconocida';
        $this->guardar($idUsuario, $usuario, $ip, $funcionalidad, $dato);
    }

    /**
     * Guarda el registro usando la estrategia configurada
     * 
     * @param int $idUsuario ID del usuario
     * @param string $usuario Nombre del usuario
     * @param string $ip Dirección IP del cliente
     * @param string $funcionalidad Nombre de la funcionalidad/ruta
     * @param mixed $dato Datos específicos de la operación
     */
    public function guardar(int $idUsuario, string $usuario, string $ip, string $funcionalidad, mixed $dato): void
    {
        $this->estrategia->guardar([
            'idUsuario' => $idUsuario,
            'usuario' => $usuario,
            'ipUsuario' => $ip,
            'funcionalidad' => $funcionalidad,
            'dato' => $dato,
        ]);
    }
}
