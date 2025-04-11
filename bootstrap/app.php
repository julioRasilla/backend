<?php

/*
* ######     #######    #     #    #######    #          #######    ######     #######    ######  
* #     #    #          #     #    #          #          #     #    #     #    #          #     # 
* #     #    #          #     #    #          #          #     #    #     #    #          #     # 
* #     #    #####      #     #    #####      #          #     #    ######     #####      ######  
* #     #    #           #   #     #          #          #     #    #          #          #   #   
* #     #    #            # #      #          #          #     #    #          #          #    #  
* ######     #######       #       #######    #######    #######    #          #######    #     # 
*/


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

/**
 * Configuración principal de la aplicación Laravel
 *
 * Este archivo define la configuración base de la aplicación incluyendo:
 * - Rutas (web, API, comandos)
 * - Middleware globales
 * - Manejo personalizado de excepciones
 * - Punto de verificación de salud
 *
 * @package App\Config
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Instancia anónima con el Trait `ApiResponses`
        $responseHelper = new class {
            use ApiResponses;
        };

        /**
         * Manejo personalizado de excepciones de autenticación
         *
         * Intercepta excepciones de tipo AuthenticationException (generalmente de Sanctum)
         * y retorna una respuesta JSON estandarizada usando el trait ApiResponses
         *
         * @param AuthenticationException $e La excepción lanzada
         * @param Request $request La solicitud HTTP
         * @return \Illuminate\Http\JsonResponse Respuesta estandarizada
         */
        $exceptions->render(function (AuthenticationException $e, Request $request) use ($responseHelper) {
            return $responseHelper->unauthorizedResponse();
        });

    })
    ->create();