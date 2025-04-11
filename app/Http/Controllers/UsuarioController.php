<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdInputRequest;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UsuarioResource;
use App\Http\Requests\UsuarioLoginRequest;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use Throwable;

/**
 * Controlador para la gestión integral de usuarios
 * 
 * Proporciona operaciones CRUD completas para la entidad Usuario, incluyendo:
 * - Registro de nuevos usuarios
 * - Autenticación y gestión de sesiones
 * - Actualización de información de usuarios
 * - Eliminación de cuentas
 * - Consulta de usuarios individuales y listados
 * 
 * Implementa:
 * - Validación robusta de datos de entrada
 * - Manejo centralizado de errores
 * - Auditoría detallada mediante sistema de logs
 * - Seguridad en contraseñas (requisitos complejos)
 * - Trazabilidad de operaciones
 * 
 * Todas las respuestas siguen el formato JSON estándar de la API
 * 
 * @package App\Http\Controllers
 */

class UsuarioController extends Controller
{
    /**
     * @var UsuarioService Servicio para manejar la lógica de usuarios
     */
    protected UsuarioService $usuarioService;

    /**
     * Constructor que inyecta el servicio de usuarios
     * 
     * @param UsuarioService $usuarioService
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Crea un nuevo usuario en el sistema
     * 
     * @param Request $request Datos del usuario a crear
     * @return JsonResponse Respuesta con el usuario creado o error
     */
    public function store(UsuarioStoreRequest $request): JsonResponse
    {
        try {
            $this->logStep('Registrar usuario');
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $usuario = $this->usuarioService->create($request->validated());

            $this->logStep('Usuario creado', ['idUsuario' => $usuario->id]);

            LogOperacion(
                auth()->id() ?? 1,
                auth()->user()->usuario ?? 'Publico',
                [
                    'datos' => $usuario
                ]
            );

            return $this->createdResponse(new UsuarioResource($usuario), 'Usuario registrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Registro de usuario');

        }
    }

    /**
     * Actualiza un usuario existente
     * 
     * @param Request $request Datos actualizados
     * @param int $id ID del usuario a actualizar
     * @return JsonResponse Respuesta con el usuario actualizado o error
     */
    public function update(UsuarioUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Iniciar actualización', ['idUsuario' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $usuarioAnterior = $this->usuarioService->getUserById($id);
            $usuarioActualizado = $this->usuarioService->update($id, $request->validated());

            $this->logStep('Usuario actualizado', ['idUsuario' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datoAnterior' => $usuarioAnterior,
                    'datoNuevo' => $usuarioActualizado
                ]
            );

            return $this->updateResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Actualización de usuario');

        }
    }

    /**
     * Elimina un usuario del sistema
     * 
     * @param Request $request
     * @param int $id ID del usuario a eliminar
     * @return JsonResponse Respuesta de éxito o error
     */
    public function destroy(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Iniciar eliminación', ['idUsuario' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);
            
            $usuarioEliminado = $this->usuarioService->delete($id);

            $this->logStep('Usuario eliminado', ['idUsuario' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $usuarioEliminado
                ]
            );

            return $this->deleteResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Eliminación de usuario');

        }
    }

    /**
     * Autentica un usuario en el sistema
     * 
     * @param Request $request Credenciales de autenticación
     * @return JsonResponse Respuesta con token de acceso o error
     */
    public function login(UsuarioLoginRequest $request): JsonResponse
    {
        try {
            $this->logStep('Iniciar autenticación');

            $credenciales = [
                'usuario' => $request->get("usuario"),
                'clave' => $request->get("clave"),
            ];

            $this->logStep('Credenciales recibidas', ['usuario' => $credenciales['usuario']]);

            $respuesta = $this->usuarioService->authenticate($credenciales);

            $this->logStep('Autenticación exitosa', ['idUsuario' => $respuesta['idUsuario']]);

            LogOperacion(
                $respuesta['idUsuario'],
                $respuesta['usuario'],
                [
                    'dato' => $respuesta
                ]
            );

            return $this->successResponse($respuesta, 'Inicio de sesión exitoso');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Autenticación de usuario');

        }
    }

    /**
     * Obtiene los datos del usuario autenticado
     * 
     * @param Request $request
     * @return JsonResponse Datos del usuario o error
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $this->logStep('Obtener usuario autenticado');

            $usuario = $this->usuarioService->getAuthenticatedUser();

            $this->logStep('Usuario obtenido', ['idUsuario' => $usuario->id]);

            return $this->successResponse(new UsuarioResource($usuario));

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de usuario autenticado');

        }
    }

    /**
     * Cierra la sesión del usuario actual
     * 
     * @param Request $request
     * @return JsonResponse Confirmación de cierre de sesión o error
     */
    public function logOut(Request $request): JsonResponse
    {
        try {
            $usuario = $request->user();

            $this->logStep('Iniciar cierre de sesión', ['idUsuario' => $usuario->id]);

            LogOperacion(
                $usuario->id,
                $usuario->usuario,
                [
                    'datos' => 'El usuario ha cerrado sesión correctamente',
                ]
            );

            $request->user()->tokens()->delete();

            $this->logStep('Sesión finalizada', ['usuario_id' => $usuario->id]);

            return $this->successResponse(null, 'Cierre de sesión exitoso');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Cierre de sesión');

        }
    }

    /**
     * Muestra los datos de un usuario específico
     * 
     * @param int $id ID del usuario a consultar
     * @return JsonResponse Datos del usuario o error
     */
    public function show(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Buscar usuario', ['idUsuario' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $usuario = $this->usuarioService->getUserById($id);

            $this->logStep('Usuario encontrado', ['idUsuario' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $usuario
                ]
            );

            return $this->successResponse(new UsuarioResource($usuario), 'Usuario encontrado');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de usuario');

        }
    }

    /**
     * Muestra los detalles completos de un usuario (con relaciones).
     * 
     * @param int $id ID del usuario
     * @return JsonResponse
     */
    public function showWithRelations(IdInputRequest $request,int $id): JsonResponse
    {
        try {
            $this->logStep('Buscar usuario con relaciones', ['idUsuario' => $id]);

            $usuario = $this->usuarioService->getUserByIdWithRelations($id);

            if (!$usuario) {
                return $this->ErrorResponse([], 'Usuario no encontrado', 404);
            }

            return $this->successResponse(new UsuarioResource($usuario), 'Usuario con detalles cargado');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de usuario con relaciones');

        }
    }


    /**
     * Lista todos los usuarios del sistema
     * 
     * @return JsonResponse Listado de usuarios o error
     */
    public function index(): JsonResponse
    {
        try {
            $this->logStep('Listar usuarios');

            $usuarios = $this->usuarioService->getAll();

            $this->logStep('Listado generado', ['Total registros' => $usuarios->count()]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $usuarios
                ]
            );

            return $this->successResponse(UsuarioResource::collection($usuarios), 'Listado de usuarios obtenido');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Listado de usuarios');

        }
    }

    /**
     * Lista todos los usuarios del sistema con sus relaciones
     * 
     * @return JsonResponse Listado de usuarios o error
     */
    public function indexWithRelations(): JsonResponse
    {
        try {
            $this->logStep('Listar usuarios');

            $usuarios = $this->usuarioService->getAllWithRelations();

            $this->logStep('Listado generado', ['Total registros' => $usuarios->count()]);

           LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $usuarios
                ]
            );

            return $this->successResponse(UsuarioResource::collection($usuarios), 'Listado de usuarios obtenido');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Listado de usuarios');
            
        }
    }
}
