<?php

namespace App\Services;

use App\Models\Empleado;
use App\Repositories\EmpleadoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\LogSistema;
use Throwable;
/**
 * Controlador para la gestión integral de Empleados
 * 
 * Proporciona operaciones CRUD completas para la entidad Empleado, incluyendo:
 * - Registro de nuevos Empleados
 * - Autenticación y gestión de sesiones
 * - Actualización de información de Empleados
 * - Eliminación de cuentas
 * - Consulta de Empleados individuales y listados
 * 
 * Implementa:
 * - Validación robusta de datos de entrada
 * - Manejo centralizado de errores
 * - Auditoría detallada mediante sistema de logs
 * - Seguridad en contraseñas (requisitos complejos)
 * - Trazabilidad de operaciones
 * 
 * Todas las respuestas siguen el formato JSON estándar de la API
 * 
 * @package App\Http\Controllers
 */
class EmpleadoService extends BaseService
{
    /**
     * Repositorio de empleados
     *
     * @var EmpleadoRepositoryInterface
     */
    protected EmpleadoRepositoryInterface $empleadoRepository;
    /**
     * Constructor de la clase EmpleadoService
     *
     * @param EmpleadoRepositoryInterface $empleadoRepository Repositorio de empleados
     */
    public function __construct(EmpleadoRepositoryInterface $empleadoRepository)    
    {
        $this->empleadoRepository = $empleadoRepository;
    }           
    /**
     * Crea un nuevo empleado en el sistema
     *
     * @param array $data Datos del empleado a crear:
     *               - nombre (string): Nombre del empleado (requerido)
     *               - apellido_paterno (string): Apellido paterno (requerido)
     *               - apellido_materno (string): Apellido materno (opcional)
     *               - telefono (string): Teléfono fijo (opcional)
     *               - telefono_celular (string): Teléfono móvil (opcional)
     * @return Empleado El empleado recién creado
     * @throws HttpException Si ocurre un error durante la creación
     */
    public function create($data)
    {
        try {

            DB::beginTransaction();

            $empleado = $this->empleadoRepository->create([
                'id_usuario_creacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'],
                'apellido_paterno' => $data['apellidoPaterno'],
                'apellido_materno' => $data['apellidoMaterno'] ?? '',
                'telefono' => $data['telefono'] ?? null,
                'telefono_celular' => $data['telefonoCelular'] ?? null,
                'activo' => true
            ]);

            DB::commit();

            return $empleado;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al registrar empleado');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al registrar empleado');
        }
    }

    /**
     * Actualiza los datos de un empleado existente
     *
     * @param int $id ID del empleado a actualizar
     * @param array $data Campos a actualizar (todos opcionales):
     *               - nombre (string)
     *               - apellido_paterno (string)
     *               - apellido_materno (string)
     *               - telefono (string)
     *               - telefono_celular (string)
     * @return Empleado El empleado con los datos actualizados
     * @throws HttpException Si el empleado no existe o hay un error en la actualización
     */
    public function update($id, $data)
    {
        try {            
            
            $empleado = $this->getEmployeeById($id);
            
            DB::beginTransaction();

            $empleado = $this->empleadoRepository->update($empleado, [
                'id_usuario_actualizacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'] ?? $empleado->nombre,
                'apellido_paterno' => $data['apellidoPaterno'] ?? $empleado->apellido_paterno,
                'apellido_materno' => $data['apellidoMaterno'] ?? $empleado->apellido_materno,
                'telefono' => $data['telefono'] ?? $empleado->telefono,
                'telefono_celular' => $data['telefonoCelular'] ?? $empleado->telefono_celular,
            ]);

            DB::commit();

            return $empleado;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e,'Error al actualizar empleado');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al actualizar empleado');
        }
    }

    /**
     * Elimina un empleado del sistema (soft delete)
     *
     * @param int $id ID del empleado a eliminar
     * @return bool True si la eliminación fue exitosa
     * @throws HttpException Si el empleado no existe o hay un error al eliminar
     */
    public function delete($id)
    {
        try {
            
            $empleado = $this->getEmployeeById($id);

            DB::beginTransaction();

            $this->empleadoRepository->delete($empleado);

            DB::commit();

            return $empleado;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al eliminar empleado');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al eliminar empleado');
        }
    }

    /**
     * Obtiene un empleado específico por su ID
     *
     * @param int $id ID del empleado a buscar
     * @return Empleado El empleado encontrado
     * @throws HttpException Si el empleado no existe o hay un error en la consulta
     */
    public function getEmployeeById($id)
    {
        try {
            $empleado = $this->empleadoRepository->findById($id);

            if (!$empleado) {
                 $this->handleNotFound('No se encontro el empleado');
            }

            return $empleado;

        } catch (QueryException $e) {
            $this->handleQueryException($e,'Error al consultar empleado');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar empleado');
        }
    }

    /**
     * Obtiene todos los empleados registrados en el sistema
     *
     * @return \Illuminate\Database\Eloquent\Collection Lista de todos los empleados
     * @throws HttpException Si hay un error al obtener los datos
     */
    public function getAll()
    {
        try {
            return $this->empleadoRepository->getAll();            
        } catch (QueryException $e) {
            $this->handleQueryException($e,'Error al obtener lista de empleados');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todos los empleados');
        }
    }

}