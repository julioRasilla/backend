<?php

namespace App\Services;

use App\Models\InstruccionPago;
use App\Repositories\InstruccionPagoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class InstruccionPagoService extends BaseService
{
    protected InstruccionPagoRepositoryInterface $instruccionPagoRepository;

    public function __construct(InstruccionPagoRepositoryInterface $instruccionPagoRepository)    
    {
        $this->instruccionPagoRepository = $instruccionPagoRepository;
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $instruccionPago = $this->instruccionPagoRepository->create([
                'nombre' => $data['nombre']
            ]);

            DB::commit();
            return $instruccionPago;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al registrar instrucción de pago');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al registrar instrucción de pago');
        }
    }

    public function update($id, $data)
    {
        try {            
            $instruccionPago = $this->getInstruccionPagoById($id);
            
            DB::beginTransaction();

            $instruccionPago = $this->instruccionPagoRepository->update($instruccionPago, [
                'nombre' => $data['nombre']
            ]);

            DB::commit();
            return $instruccionPago;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al actualizar instrucción de pago');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al actualizar instrucción de pago');
        }
    }

    public function delete($id)
    {
        try {
            $instruccionPago = $this->getInstruccionPagoById($id);

            DB::beginTransaction();
            $this->instruccionPagoRepository->delete($instruccionPago);
            DB::commit();

            return true;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al eliminar instrucción de pago');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al eliminar instrucción de pago');
        }
    }

    public function getInstruccionPagoById($id)
    {
        try {
            $instruccionPago = $this->instruccionPagoRepository->findById($id);

            if (!$instruccionPago) {
                 $this->handleNotFound('No se encontró la instrucción de pago');
            }

            return $instruccionPago;

        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar instrucción de pago');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar instrucción de pago');
        }
    }

    public function getAll()
    {
        try {
            return $this->instruccionPagoRepository->getAll();            
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de instrucciones de pago');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todas las instrucciones de pago');
        }
    }
}