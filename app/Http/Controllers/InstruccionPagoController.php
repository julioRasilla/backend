<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstruccionPagoResource;
use App\Services\InstruccionPagoService;
use App\Http\Requests\InstruccionPagoStoreRequest;
use App\Http\Requests\InstruccionPagoUpdateRequest;
use App\Http\Requests\IdInputRequest;
use Throwable;

class InstruccionPagoController extends Controller
{
    protected InstruccionPagoService $instruccionPagoService;

    public function __construct(InstruccionPagoService $instruccionPagoService)
    {
        $this->instruccionPagoService = $instruccionPagoService;
    }

    public function store(InstruccionPagoStoreRequest $request)
    {
        try {
            $instruccionPago = $this->instruccionPagoService->create($request->validated());
            return $this->createdResponse(new InstruccionPagoResource($instruccionPago), 'La instrucción de pago fue registrada con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Registro de instrucción de pago');
        }
    }

    public function update(InstruccionPagoUpdateRequest $request, $id)
    {
        try {
            $this->instruccionPagoService->update($id, $request->validated());
            return $this->updateResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Actualización de instrucción de pago');
        }
    }

    public function destroy(IdInputRequest $request, $id)
    {
        try {
            $this->instruccionPagoService->delete($id);
            return $this->deleteResponse();
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Eliminación de instrucción de pago');
        }
    }

    public function show(IdInputRequest $request, $id)
    {
        try {
            $instruccionPago = $this->instruccionPagoService->getInstruccionPagoById($id);
            return $this->successResponse(new InstruccionPagoResource($instruccionPago), 'Instrucción de pago encontrada con éxito');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Consulta de instrucción de pago por ID');
        }
    }

    public function index()
    {
        try {
            $instruccionesPago = $this->instruccionPagoService->getAll();
            return $this->successResponse(InstruccionPagoResource::collection($instruccionesPago), 'Listado de instrucciones de pago');
        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Listado de instrucciones de pago');
        }
    }
}