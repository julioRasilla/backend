<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlantillaAsuntoResource;
use App\Services\PlantillaAsuntoService;
use App\Http\Requests\PlantillaAsuntoStoreRequest;
use App\Http\Requests\PlantillaAsuntoUpdateRequest;
use App\Http\Requests\IdInputRequest;
use Throwable;

class PlantillaAsuntoController extends Controller
{
    protected PlantillaAsuntoService $plantillaAsuntoService;

    public function __construct(PlantillaAsuntoService $plantillaAsuntoService)
    {
        $this->plantillaAsuntoService = $plantillaAsuntoService;
    }

    public function store(PlantillaAsuntoStoreRequest $request)
    {
        try {
            $plantillaAsunto = $this->plantillaAsuntoService->create($request->validated());
            return $this->createdResponse(new PlantillaAsuntoResource($plantillaAsunto), 'La plantilla de asunto fue registrada con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Registro de plantilla de asunto');
        }
    }

    public function update(PlantillaAsuntoUpdateRequest $request, $id)
    {
        try {
            $this->plantillaAsuntoService->update($id, $request->validated());
            return $this->updateResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Actualización de plantilla de asunto');
        }
    }

    public function destroy(IdInputRequest $request, $id)
    {
        try {
            $this->plantillaAsuntoService->delete($id);
            return $this->deleteResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Eliminación de plantilla de asunto');
        }
    }

    public function show(IdInputRequest $request, $id)
    {
        try {
            $plantillaAsunto = $this->plantillaAsuntoService->getPlantillaAsuntoById($id);
            return $this->successResponse(new PlantillaAsuntoResource($plantillaAsunto), 'Plantilla de asunto encontrada con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Consulta de plantilla de asunto por ID');
        }
    }

    public function index()
    {
        try {
            $plantillasAsunto = $this->plantillaAsuntoService->getAll();
            return $this->successResponse(PlantillaAsuntoResource::collection($plantillasAsunto), 'Listado de plantillas de asunto');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Listado de plantillas de asunto');
        }
    }
}