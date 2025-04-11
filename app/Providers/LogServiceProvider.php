<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Logging\BitacoraSistemaContext;
use App\Logging\BitacoraSistemaEstrategia;
use App\Logging\BitacoraSistemaArchivo;
use App\Logging\BitacoraSistemaBaseDatos;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Registra los servicios del proveedor.
     * 
     * Configura la estrategia de almacenamiento de bitácora según la configuración
     * y registra las dependencias en el contenedor de servicios.
     *
     * @return void
     */
    public function register(): void
    {
        // Obtiene el tipo de almacenamiento desde la configuración (default: 'file')
        $storageType = Config::get('bitacora_sistema.storage', 'file');
        Log::info("Bitácora - Tipo de almacenamiento seleccionado: " . $storageType);

        /**
         * Registra la estrategia de almacenamiento como singleton.
         * 
         * Dependiendo de la configuración, instancia:
         * - BitacoraSistemaBaseDatos para almacenamiento en base de datos
         * - BitacoraSistemaArchivo para almacenamiento en archivo (default)
         */
        $this->app->singleton(BitacoraSistemaEstrategia::class, function () use ($storageType) {
            return match ($storageType) {
                'database' => new BitacoraSistemaBaseDatos(),
                default => new BitacoraSistemaArchivo(),
            };
        });

        /**
         * Registra el contexto de bitácora como servicio 'log.sistema'.
         * 
         * Inyecta automáticamente la estrategia de almacenamiento configurada.
         */
        $this->app->singleton('log.sistema', function ($app) {
            return new BitacoraSistemaContext(
                $app->make(BitacoraSistemaEstrategia::class)
            );
        });
    }

    /**
     * Arranca los servicios del proveedor.
     * 
     * @return void
     */
    public function boot(): void
    {
        // Método dejado intencionalmente vacío para futuras extensiones
    }
}