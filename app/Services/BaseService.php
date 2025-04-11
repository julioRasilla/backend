<?php

namespace App\Services;

use App\Traits\ApiFormatTrait;
use Illuminate\Database\QueryException;
use App\Facades\LogSistema;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Constants\DbErrorCodes;
use Throwable;

/**
 * Clase base para servicios de la aplicación
 *
 * Proporciona funcionalidad común a través del trait ApiFormatTrait:
 * - Métodos estandarizados para formatear respuestas API
 * - Funciones auxiliares para manejo de errores
 * - Estructura consistente para respuestas JSON
 */
class BaseService
{
    use ApiFormatTrait;

    /**
     * Maneja excepciones de tipo QueryException de manera uniforme.
     *
     * @param QueryException $e
     * @param string $message
     * @throws HttpException
     */
    protected function handleQueryException(QueryException $e, string $message)
    {
        $errorInfo = [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
            'trace_as_string' => $e->getTraceAsString(),
            'previous' => $e->getPrevious()?->getMessage(),
            'class' => get_class($e),
        ];

        LogSistema::registrar([
            class_basename(static::class) => "Error en base de datos",
            'error' => $errorInfo,
            'codeDatabase' => $e->errorInfo[0] ?? null,
        ]);

        $status = ($e->errorInfo[0] ?? null) === DbErrorCodes::UNIQUE_VIOLATION 
            ? Response::HTTP_CONFLICT 
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $userMessage = ($e->errorInfo[0] ?? null) === DbErrorCodes::UNIQUE_VIOLATION
            ? "El recurso ya existe en el sistema" 
            : $message;

        throw new HttpException($status, json_encode($this->errorArray($e->errorInfo[0] ?? null, $userMessage)));
    }

    /**
     * Maneja cualquier excepción genérica (Throwable).
     *
     * @param Throwable $e
     * @param string $context
     * @throws Throwable
     */
    protected function handleThrowable(Throwable $e, string $context)
    {
        $errorInfo = [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
            'trace_as_string' => $e->getTraceAsString(),
            'previous' => $e->getPrevious()?->getMessage(),
            'class' => get_class($e),
        ];

        LogSistema::registrar([
            class_basename(static::class) => $context,
            'error' => $errorInfo,
        ]);

        throw $e;
    }

    /**
     * Lanza una excepción HTTP 404 con mensaje personalizado.
     *
     * @param string $message
     * @throws HttpException
     */
    protected function handleNotFound(string $message)
    {
        throw new HttpException(
            Response::HTTP_NOT_FOUND,
            json_encode($this->errorArray(Response::HTTP_NOT_FOUND, $message))
        );
    }
    
}