<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponses;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Facades\LogSistema;
use Illuminate\Http\JsonResponse;

/**
 * Controlador base abstracto para toda la aplicación
 * 
 * Proporciona funcionalidad común a través del trait ApiResponses:
 * - Respuestas API estandarizadas (éxito/error)
 * 
 * @see \App\Traits\ApiResponses
 * @abstract
 */
abstract class Controller
{
    use ApiResponses;

    protected function handleErrors(Throwable $e, string $contexto): JsonResponse
    {
        $this->logStep($contexto, ['Error' => $e->getMessage()]);

        if ($e instanceof ValidationException) {
            return $this->validationErrorResponse($e->errors());
        } elseif ($e instanceof HttpException) {
            return $this->DataBaseErrorResponse($e->getMessage(), "Error de base de datos", $e->getStatusCode());
        }

        return $this->ErrorResponse($e->getMessage(), "Error inesperado en: $contexto");
    }

    protected function logStep(string $paso, array $datos = []): void
    {
        LogSistema::registrar(array_merge(['Paso' => $paso], $datos));
    }

}