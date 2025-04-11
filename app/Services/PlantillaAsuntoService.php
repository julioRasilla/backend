<?php

namespace App\Services;

use App\Models\PlantillaAsunto;
use App\Repositories\PlantillaAsuntoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PlantillaAsuntoService extends BaseService
{
    protected PlantillaAsuntoRepositoryInterface $plantillaAsuntoRepository;

    public function __construct(PlantillaAsuntoRepositoryInterface $plantillaAsuntoRepository)    
    {
        $this->plantillaAsuntoRepository = $plantillaAsuntoRepository;
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $plantillaAsunto = $this->plantillaAsuntoRepository->create([
                'nombre' => $data['nombre'],
                'plantilla' => $data['plantilla']
            ]);

            DB::commit();
            return $plantillaAsunto;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al registrar plantilla de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al registrar plantilla de asunto');
        }
    }

    public function update($id, $data)
    {
        try {            
            $plantillaAsunto = $this->getPlantillaAsuntoById($id);
            
            DB::beginTransaction();

            $plantillaAsunto = $this->plantillaAsuntoRepository->update($plantillaAsunto, [
                'nombre' => $data['nombre'],
                'plantilla' => $data['plantilla']
            ]);

            DB::commit();
            return $plantillaAsunto;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al actualizar plantilla de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al actualizar plantilla de asunto');
        }
    }

    public function delete($id)
    {
        try {
            $plantillaAsunto = $this->getPlantillaAsuntoById($id);

            DB::beginTransaction();
            $this->plantillaAsuntoRepository->delete($plantillaAsunto);
            DB::commit();

            return true;

        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleQueryException($e, 'Error al eliminar plantilla de asunto');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleThrowable($e, 'Error desconocido al eliminar plantilla de asunto');
        }
    }

    public function getPlantillaAsuntoById($id)
    {
        try {
            $plantillaAsunto = $this->plantillaAsuntoRepository->findById($id);

            if (!$plantillaAsunto) {
                 $this->handleNotFound('No se encontró la plantilla de asunto');
            }

            return $plantillaAsunto;

        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar plantilla de asunto');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar plantilla de asunto');
        }
    }

    public function getAll()
    {
        try {
            return $this->plantillaAsuntoRepository->getAll();            
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de plantillas de asunto');
        } catch (\Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todas las plantillas de asunto');
        }
    }
}