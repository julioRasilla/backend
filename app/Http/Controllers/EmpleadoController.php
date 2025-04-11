<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmpleadoResource;
use App\Services\EmpleadoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\EmpleadoStoreRequest;
use App\Http\Requests\EmpleadoUpdateRequest;
use App\Http\Requests\IdInputRequest;
use Throwable;

/**
 * Controlador para la gestión de empleados
 * 
 * Proporciona operaciones CRUD completas para la entidad Empleado:
 * - Creación de nuevos empleados
 * - Actualización de información de empleados
 * - Eliminación de registros de empleados
 * - Consulta individual y listado de empleados
 * 
 * Implementa:
 * - Validación de datos de entrada
 * - Manejo centralizado de errores
 * - Sistema de logging para auditoría
 * - Respuestas JSON estandarizadas
 */
class EmpleadoController extends Controller
{
    /**
     * @var EmpleadoService Servicio para manejar la lógica de empleados
     */
    protected EmpleadoService $empleadoService;

    /**
     * Constructor que inyecta el servicio de empleados
     * 
     * @param EmpleadoService $empleadoService
     */
    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    /**
     * Crea un nuevo empleado en el sistema
     * 
     * @param Request $request Datos del empleado a crear
     * @return JsonResponse Respuesta con el empleado creado o error
     * 
     * @throws ValidationException Si los datos no pasan la validación
     */
    public function store(EmpleadoStoreRequest $request): JsonResponse
    {
        try {
            $this->logStep('Crear nuevo empleado');
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $empleado = $this->empleadoService->create($request->validated());

            $this->logStep('Empleado creado', ['idEmpleado' => $empleado->id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $empleado
                ]
            );

            return $this->createdResponse(new EmpleadoResource($empleado), 'El empleado fue registrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Registro de empleado');

        }
    }

    /**
     * Actualiza la información de un empleado existente
     * 
     * @param Request $request Datos actualizados del empleado
     * @param int $id ID del empleado a actualizar
     * @return JsonResponse Respuesta con éxito o error
     */
    public function update(EmpleadoUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Actualizar empleado', ['idEmpleado' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $empleadoAnterior = $this->empleadoService->getEmployeeById($id);
            $empleadoActualizado = $this->empleadoService->update($id,$request->validated());

            $this->logStep('Empleado actualizado', ['idEmpleado' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' =>[
                        'anterior' => $empleadoAnterior,
                        'nuevo' => $empleadoActualizado
                    ]
                ]
            );            

            return $this->updateResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Actualización de empleado');

        }
    }

    /**
     * Elimina un empleado del sistema
     * 
     * @param Request $request
     * @param int $id ID del empleado a eliminar
     * @return JsonResponse Respuesta de éxito o error
     */
    public function destroy(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Eliminar empleado', ['idEmpleado' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $datosEmpleado = $this->empleadoService->delete($id);

            $this->logStep('Empleado eliminado correctamente', ['idEmpleado' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $datosEmpleado
                ]
            );            

            return $this->deleteResponse();

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Eliminación de empleado');

        }
    }

    /**
     * Muestra los datos de un empleado específico
     * 
     * @param Request $request
     * @param int $id ID del empleado a consultar
     * @return JsonResponse Datos del empleado o error
     */
    public function show(IdInputRequest $request, $id): JsonResponse
    {
        try {
            $this->logStep('Buscar empleado por ID', ['idEmpleado' => $id]);
            $this->logStep('Datos recibidos', ['Datos' => $request->all()]);

            $empleado = $this->empleadoService->getEmployeeById($id);

            $this->logStep('Empleado encontrado', ['idEmpleado' => $id]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $empleado
                ]
            );                  

            return $this->successResponse(new EmpleadoResource($empleado), 'Empleado encontrado con éxito');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Consulta de empleado por ID');

        }
    }

    /**
     * Lista todos los empleados del sistema
     * 
     * @return JsonResponse Listado de empleados o error
     */
    public function index(): JsonResponse
    {
        try {
            $this->logStep('Listar empleados');

            $empleados = $this->empleadoService->getAll();

            $this->logStep('Listado generado', ['Total registros' => $empleados->count()]);

            LogOperacion(
                auth()->id(),
                auth()->user()->usuario,
                [
                    'datos' => $empleados
                ]
            );            

            return $this->successResponse(EmpleadoResource::collection($empleados), 'Listado de empleados');

        } catch (Throwable $e) {

            return $this->handleErrors($e, 'Listado de empleados');
            
        }
    }

}