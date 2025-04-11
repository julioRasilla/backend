<?php

namespace App\Services;

use App\Models\Perfil;
use App\Repositories\PerfilRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\LogSistema;
use Throwable;

/**
 * Servicio para la gestión de perfiles de usuario y sus privilegios asociados.
 * 
 * Proporciona métodos para crear, actualizar, eliminar y consultar perfiles,
 * así como para asignar privilegios a los mismos. Maneja transacciones de base
 * de datos y errores de manera consistente.
 */
class PerfilService extends BaseService
{
    /**
     * Interfaz del repositorio de perfiles.
     *
     * @var PerfilRepositoryInterface
     */

    protected PerfilRepositoryInterface $perfilRepository;

    /**
     * Constructor del servicio de perfiles.
     *
     * @param PerfilRepositoryInterface $perfilRepository Repositorio de perfiles
     */
    public function __construct(PerfilRepositoryInterface $perfilRepository)
    {
        $this->perfilRepository = $perfilRepository;
    }    

    /**
     * Crea un nuevo perfil con los datos proporcionados.
     *
     * @param array $data Datos del perfil a crear:
     *                    - nombre: Nombre del perfil (requerido)
     *                    - activo: Estado activo/inactivo (opcional, default true)
     *                    - privilegios: Array de privilegios a asignar (opcional)
     * @return Perfil El perfil recién creado
     * @throws HttpException Si ocurre algún error durante la creación
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $perfil = $this->perfilRepository->create([
                'id_usuario_creacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'],
                'activo' => $data['activo'] ?? true
            ]);

            if (isset($data['privilegios'])) {
                $this->perfilRepository->asignarPrivilegios($perfil->id, $data['privilegios']);
            }

            DB::commit();

            return $perfil;
            
        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al registrar perfil');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al registrar perfil');
        }
    }

    /**
     * Actualiza un perfil existente con los nuevos datos proporcionados.
     *
     * @param int $id ID del perfil a actualizar
     * @param array $data Datos a actualizar:
     *                    - nombre: Nuevo nombre (opcional)
     *                    - activo: Nuevo estado (opcional)
     *                    - privilegios: Nuevos privilegios (si se proporciona, reemplaza los existentes)
     * @return Perfil El perfil actualizado
     * @throws HttpException Si el perfil no existe o ocurre un error durante la actualización
     */
    public function update($id, $data)
    {
        try {
            $perfil = $this->getProfileById($id);

            DB::beginTransaction();

            $perfil = $this->perfilRepository->update(
                $perfil, 
                [
                'id_usuario_actualizacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'] ?? $perfil->nombre,
                'activo' => $data['activo'] ?? $perfil->activo,]
            );

            if (isset($data['privilegios'])) {
                $this->perfilRepository->eliminarPrivilegios($perfil);
                $this->perfilRepository->asignarPrivilegios($perfil->id, $data['privilegios']);
            }

            DB::commit();

            return $perfil;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al actualizar perfil');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al actualizar perfil');
        }
    }

    /**
     * Elimina un perfil y todos sus privilegios asociados.
     *
     * @param int $id ID del perfil a eliminar
     * @return bool True si la eliminación fue exitosa
     * @throws HttpException Si el perfil no existe o ocurre un error durante la eliminación
     */
    public function delete($id)
    {
        try {
            $perfil = $this->getProfileById($id);

            DB::beginTransaction();

            $this->perfilRepository->eliminarPrivilegios($perfil);
            $this->perfilRepository->delete($perfil);

            DB::commit();

            return $perfil;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al eliminar perfil');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al eliminar perfil');
        }
    }

    /**
     * Obtiene un perfil por su ID.
     *
     * @param int $id ID del perfil a consultar
     * @return Perfil El perfil encontrado
     * @throws HttpException Si el perfil no existe o ocurre un error durante la consulta
     */
    public function getProfileById($id)
    {
        try {
            $perfil = $this->perfilRepository->findById($id);

            if (!$perfil) {
                $this->handleNotFound('No se encontró el perfil');
            }

            return $perfil;

        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar perfil');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar perfil');
        }
    }

    /**
     * Obtiene todos los perfiles existentes en el sistema.
     *
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los perfiles
     * @throws HttpException Si ocurre un error durante la consulta
     */
    public function getAll()
    {
        try {
            return $this->perfilRepository->getAll();
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de perfiles');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todos los perfiles');
        }
    }

}