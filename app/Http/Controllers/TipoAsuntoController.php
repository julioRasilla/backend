<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipoAsuntoResource;
use App\Services\TipoAsuntoService;
use App\Http\Requests\TipoAsuntoStoreRequest;
use App\Http\Requests\TipoAsuntoUpdateRequest;
use App\Http\Requests\IdInputRequest;
use Throwable;

class TipoAsuntoController extends Controller
{
    protected TipoAsuntoService $tipoAsuntoService;

    public function __construct(TipoAsuntoService $tipoAsuntoService)
    {
        $this->tipoAsuntoService = $tipoAsuntoService;
    }

    public function store(TipoAsuntoStoreRequest $request)
    {
        try {
            $tipoAsunto = $this->tipoAsuntoService->create($request->validated());
            return $this->createdResponse(new TipoAsuntoResource($tipoAsunto), 'El tipo de asunto fue registrado con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Registro de tipo de asunto');
        }
    }

    public function update(TipoAsuntoUpdateRequest $request, $id)
    {
        try {
            $this->tipoAsuntoService->update($id, $request->validated());
            return $this->updateResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Actualización de tipo de asunto');
        }
    }

    public function destroy(IdInputRequest $request, $id)
    {
        try {
            $this->tipoAsuntoService->delete($id);
            return $this->deleteResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Eliminación de tipo de asunto');
        }
    }

    public function show(IdInputRequest $request, $id)
    {
        try {
            $tipoAsunto = $this->tipoAsuntoService->getTipoAsuntoById($id);
            return $this->successResponse(new TipoAsuntoResource($tipoAsunto), 'Tipo de asunto encontrado con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Consulta de tipo de asunto por ID');
        }
    }

    public function index()
    {
        try {
            $tiposAsunto = $this->tipoAsuntoService->getAll();
            return $this->successResponse(TipoAsuntoResource::collection($tiposAsunto), 'Listado de tipos de asunto');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Listado de tipos de asunto');
        }
    }
}