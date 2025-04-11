<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClienteResource;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Http\Requests\IdInputRequest;
use Throwable;

/**
 * Controlador para la gestión de clientes
 * 
 * Proporciona operaciones CRUD completas para la entidad Cliente:
 * - Creación de nuevos clientes
 * - Actualización de información de clientes
 * - Eliminación de registros
 * - Consulta individual y listado de clientes
 * 
 * Implementa:
 * - Validación de datos de entrada
 * - Manejo centralizado de errores
 * - Sistema de logging para auditoría
 * - Respuestas JSON estandarizadas
 */
class ClienteController extends Controller
{
    /**
     * @var ClienteService Servicio para manejar la lógica de clientes
     */
    protected ClienteService $clienteService;

    /**
     * Constructor que inyecta el servicio de clientes
     * 
     * @param ClienteService $clienteService
     */
    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * Crea un nuevo cliente en el sistema
     * 
     * @param Request $request Datos del cliente a crear
     * @return JsonResponse Respuesta con el cliente creado o error
     * 
     * @throws ValidationException Si los datos no pasan la validación
     */
    public function store(ClienteStoreRequest $request): JsonResponse
    {
        try {
            $this->logStep('Crear nuevo cliente');
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $cliente = $this->clienteService->create($request->validated());

            $this->logStep('Cliente creado', ['idCliente' => $cliente->id]);

            LogOperacion(
                auth()->id() ?? 1,
                auth()->user()->usuario ?? 'Publico',
                [
                    'datos' => $cliente
                ]
            );

            return $this->createdResponse(new ClienteResource($cliente), 'El cliente fue registrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Registro de cliente');

        }
    }

    /**
     * Actualiza la información de un cliente existente
     * 
     * @param Request $request Datos actualizados del cliente
     * @param int $id ID del cliente a actualizar
     * @return JsonResponse Respuesta con éxito o error
     */
    public function update(ClienteUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Actualizar cliente', ['idCliente' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $clienteAnterior = $this->clienteService->getClientById($id);
            $clienteActualizado = $this->clienteService->update($id, $request->validated());

            $this->logStep('Cliente actualizado', ['idCliente' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' =>[
                        'anterior' => $clienteAnterior,
                        'nuevo' => $clienteActualizado
                    ]
                ]
            );            

            return $this->updateResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Actualización de cliente');

        }
    }

    /**
     * Elimina un cliente del sistema
     * 
     * @param Request $request
     * @param int $id ID del cliente a eliminar
     * @return JsonResponse Respuesta de éxito o error
     */
    public function destroy(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Eliminar cliente', ['idCliente' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);
            
            $datosCliente = $this->clienteService->delete($id);

            $this->logStep('Cliente eliminado correctamente', ['idCliente' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $datosCliente
                ]
            );            

            return $this->deleteResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Eliminación de cliente');

        }
    }

    /**
     * Muestra los datos de un cliente específico
     * 
     * @param Request $request
     * @param int $id ID del cliente a consultar
     * @return JsonResponse Datos del cliente o error
     */
    public function show(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Buscar cliente por ID', ['idCliente' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $cliente = $this->clienteService->getClientById($id);

            $this->logStep('Cliente encontrado', ['idCliente' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $cliente
                ]
            );                  

            return $this->successResponse(New ClienteResource($cliente), 'Cliente encontrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de cliente por ID');

        }
    }

    /**
     * Lista todos los clientes del sistema
     * 
     * @return JsonResponse Listado de clientes o error
     */
    public function index(): JsonResponse
    {
        try {
            $this->logStep('Listar clientes');

            $clientes = $this->clienteService->getAll();

            $this->logStep('Listado generado', ['Total registros' => $clientes->count()]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $clientes
                ]
            );            

            return $this->successResponse(ClienteResource::collection($clientes), 'Listado de clientes');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Listado de clientes');
            
        }
    }

}