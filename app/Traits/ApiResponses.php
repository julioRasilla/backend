<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

/**
 * Trait para estandarizar respuestas API
 * 
 * Proporciona métodos predefinidos para respuestas JSON consistentes
 * en toda la aplicación.
 */
trait ApiResponses
{
    /**
     * Respuesta para actualización exitosa (204 No Content)
     */
    public function updateResponse()
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Respuesta para eliminación exitosa (204 No Content)
     */
    public function deleteResponse()
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Respuesta para errores de validación (422 Unprocessable Entity)
     * 
     * @param array $errors Errores de validación
     */
    public function validationErrorResponse(array $errors)
    {
        return response()->json([
            'message' => 'Error de validación.',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Respuesta exitosa genérica (200 OK)
     * 
     * @param mixed $data Datos a retornar
     * @param string $message Mensaje descriptivo
     */
    public function successResponse($data, string $message = 'Operación exitosa.')
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Respuesta para creación exitosa (201 Created)
     * 
     * @param mixed $data Datos del recurso creado
     * @param string $message Mensaje descriptivo
     */
    public function createdResponse($data, string $message = 'Recurso creado exitosamente.')
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Respuesta para errores genéricos (500 Internal Server Error)
     * 
     * @param mixed $data Datos del error
     * @param string $message Mensaje descriptivo
     */
    public function ErrorResponse($data, string $message = 'Error desconocido')
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            $data = json_last_error() === JSON_ERROR_NONE ? $decoded : $data;
        }

        return response()->json([
            'message' => $message,
            'errors' => $data
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Respuesta para errores de base de datos
     * 
     * @param mixed $data Datos del error
     * @param string $message Mensaje descriptivo
     * @param int $statusCode Código HTTP personalizado
     */
    public function DataBaseErrorResponse($data, string $message = 'Error desconocido', int $statusCode = 0)
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            $data = json_last_error() === JSON_ERROR_NONE ? $decoded : $data;
        }

        return response()->json([
            'message' => $message,
            'errors' => $data
        ], $statusCode);
    }

    /**
     * Respuesta para acceso no autorizado (401 Unauthorized)
     */
    public function UnauthorizedResponse()
    {
        return response()->json([
            'message' => 'No autorizado.',
            'errors' => [
                'auth' => ['El token de acceso es inválido o ha expirado.']
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }
}