<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EmpleadoRepositoryInterface;
use App\Repositories\EmpleadoRepository;
use App\Repositories\ClienteRepositoryInterface;
use App\Repositories\ClienteRepository;
use App\Repositories\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use App\Repositories\PerfilRepositoryInterface;
use App\Repositories\PerfilRepository;

/**
 * Proveedor de servicios principal de la aplicación
 *
 * Esta clase es el punto central para registrar servicios y realizar
 * configuraciones de bootstrap para la aplicación.
 *
 * Funcionalidades clave:
 * - Registro de bindings de servicios
 * - Configuraciones iniciales de la aplicación
 * - Registro de listeners de eventos
 *
 * Ciclo de vida:
 * 1. El método register() se ejecuta primero durante el bootstrap
 * 2. El método boot() se ejecuta después de todos los providers están registrados
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios en el contenedor de inyección de dependencias
     *
     * Este método se ejecuta antes del boot y es ideal para:
     * - Registrar bindings de clases
     * - Configurar singletons
     * - Definir interfaces concretas
     *
     * @return void
     */
    public function register(): void
    {

        $this->app->bind(EmpleadoRepositoryInterface::class, EmpleadoRepository::class);
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class,UsuarioRepository::class);
        $this->app->bind(PerfilRepositoryInterface::class,PerfilRepository::class);

    }

    /**
     * Inicializa servicios y configuración de la aplicación
     *
     * Este método se ejecuta después de que todos los providers
     * han sido registrados y es ideal para:
     * - Registrar listeners de eventos
     * - Publicar assets
     * - Realizar configuraciones iniciales
     *
     * @return void
     */
    public function boot(): void
    {
        // Aquí se pueden registrar eventos usando Event::listen()
    }
}