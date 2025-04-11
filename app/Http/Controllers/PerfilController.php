<?php

namespace App\Http\Controllers;

use App\Services\PerfilService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\PerfilResource;
use App\Http\Requests\PerfilStoreRequest;
use App\Http\Requests\PerfilUpdateRequest;
use App\Http\Requests\IdInputRequest;

use Throwable;

/**
 * Controlador para la gestión de perfiles de usuario.
 * 
 * Proporciona endpoints para operaciones CRUD de perfiles,
 * incluyendo creación, actualización, eliminación y consulta.
 */
class PerfilController extends Controller
{
    /**
     * Instancia del servicio de perfiles.
     * @var PerfilService
     */
    protected PerfilService $perfilService;

    /**
     * Constructor del controlador.
     * @param PerfilService $perfilService Servicio inyectado para gestión de perfiles
     */
    public function __construct(PerfilService $perfilService)
    {
        $this->perfilService = $perfilService;
    }

    /**
     * Crea un nuevo perfil en el sistema.
     * 
     * @param Request $request Datos de la solicitud
     * @return JsonResponse Respuesta JSON con el resultado de la operación
     */
    public function store(PerfilStoreRequest $request): JsonResponse
    {
        try {
            $this->logStep('Crear nuevo perfil');
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $perfil = $this->perfilService->create($request->validated());

            $this->logStep('Perfil creado', ['idPerfil' => $perfil->id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                ['datos' => $perfil->load('privilegios')]
            );

            return $this->createdResponse(new PerfilResource($perfil->load('privilegios')), 'El perfil fue registrado con éxito');

        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Registro de perfil');
        }
    }

    /**
     * Actualiza un perfil existente.
     * 
     * @param Request $request Datos de la solicitud
     * @param int $id ID del perfil a actualizar
     * @return JsonResponse Respuesta JSON con el resultado de la operación
     */
    public function update(PerfilUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Actualizar perfil', ['idPerfil' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $perfilAnterior = $this->perfilService->getProfileById($id);
            $perfilActualizado = $this->perfilService->update($id, $request->validated());

            $this->logStep('Perfil actualizado', ['idPerfil' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => [
                        'anterior' => $perfilAnterior->load('privilegios'),
                        'nuevo' => $perfilActualizado->load('privilegios')
                    ]
                ]
            );            

            return $this->updateResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Actualización de perfil');

        }
    }

    /**
     * Elimina un perfil del sistema.
     * 
     * @param Request $request Datos de la solicitud
     * @param int $id ID del perfil a eliminar
     * @return JsonResponse Respuesta JSON con el resultado de la operación
     */
    public function destroy(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Eliminar perfil', ['idPerfil' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);
            
            $datosPerfil = $this->perfilService->delete($id);

            $this->logStep('Perfil eliminado correctamente', ['idPerfil' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                ['datos' => $datosPerfil]
            );            

            return $this->deleteResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Eliminación de perfil');

        }
    }

    /**
     * Obtiene los detalles de un perfil específico.
     * 
     * @param Request $request Datos de la solicitud
     * @param int $id ID del perfil a consultar
     * @return JsonResponse Respuesta JSON con los datos del perfil
     */
    public function show(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Buscar perfil por ID', ['idPerfil' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $perfil = $this->perfilService->getProfileById($id);
            
            $this->logStep('Perfil encontrado', ['idPerfil' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                ['datos' => $perfil->load('privilegios')]
            );                  

            return $this->successResponse(new PerfilResource($perfil), 'Perfil encontrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de perfil por ID');

        }
    }

    /**
     * Obtiene un listado de todos los perfiles del sistema.
     * 
     * @return JsonResponse Respuesta JSON con la lista de perfiles
     */
    public function index(): JsonResponse
    {
        try {
            $this->logStep('Listar perfiles');
            $perfiles = $this->perfilService->getAll();
            $this->logStep('Listado generado', ['Total registros' => $perfiles->count()]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                ['datos' => $perfiles->load('privilegios')]
            );     

            return $this->successResponse(PerfilResource::collection($perfiles), 'Listado de perfiles');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Listado de perfiles');
            
        }
    }
}