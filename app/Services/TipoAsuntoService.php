<?php

namespace App\Services;

use App\Models\TipoAsunto;
use App\Repositories\TipoAsuntoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TipoAsuntoService extends BaseService
{
    protected TipoAsuntoRepositoryInterface $tipoAsuntoRepository;

    public function __construct(TipoAsuntoRepositoryInterface $tipoAsuntoRepository)    
    {
        $this->tipoAsuntoRepository = $tipoAsuntoRepository;
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $tipoAsunto = $this->tipoAsuntoRepository->create([
                'nombre' => $data['nombre']
            ]);

            DB::commit();

            return $tipoAsunto;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al registrar tipo de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al registrar tipo de asunto');
        }
    }

    public function update($id, $data)
    {
        try {            
            $tipoAsunto = $this->getTipoAsuntoById($id);
            
            DB::beginTransaction();

            $tipoAsunto = $this->tipoAsuntoRepository->update($tipoAsunto, [
                'nombre' => $data['nombre']
            ]);

            DB::commit();

            return $tipoAsunto;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al actualizar tipo de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al actualizar tipo de asunto');
        }
    }

    public function delete($id)
    {
        try {
            $tipoAsunto = $this->getTipoAsuntoById($id);

            DB::beginTransaction();

            $this->tipoAsuntoRepository->delete($tipoAsunto);

            DB::commit();

            return true;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al eliminar tipo de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al eliminar tipo de asunto');
        }
    }

    public function getTipoAsuntoById($id)
    {
        try {
            $tipoAsunto = $this->tipoAsuntoRepository->findById($id);

            if (!$tipoAsunto) {
                 $this->handleNotFound('No se encontró el tipo de asunto');
            }

            return $tipoAsunto;

        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar tipo de asunto');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar tipo de asunto');
        }
    }

    public function getAll()
    {
        try {
            return $this->tipoAsuntoRepository->getAll();            
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de tipos de asunto');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todos los tipos de asunto');
        }
    }
}