<?php

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Servicio para la gestión integral de clientes
 * 
 * Proporciona operaciones CRUD completas para la entidad Cliente, incluyendo:
 * - Registro de nuevos clientes
 * - Actualización de información de clientes
 * - Eliminación de registros
 * - Consulta de clientes individuales y listados
 * 
 * Implementa:
 * - Validación robusta de datos de entrada
 * - Manejo centralizado de errores
 * - Auditoría detallada mediante sistema de logs
 * - Trazabilidad de operaciones
 */
class ClienteService extends BaseService
{
    /**
     * @var ClienteRepositoryInterface
     */
    protected ClienteRepositoryInterface $clienteRepository;

    /**
     * Constructor del servicio de cliente
     *
     * @param ClienteRepositoryInterface $clienteRepository Repositorio de cliente
     */
    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }
    /**
     * Crea un nuevo cliente en el sistema
     *
     * @param array $data Datos del cliente a crear:
     *               - nombre (string): Nombre del cliente (requerido)
     *               - apellido_paterno (string): Apellido paterno (requerido)
     *               - apellido_materno (string): Apellido materno (opcional)
     *               - telefono (string): Teléfono fijo (opcional)
     *               - telefono_celular (string): Teléfono móvil (opcional)
     * @return Cliente El cliente recién creado
     * @throws HttpException Si ocurre un error durante la creación
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();
            
            $cliente = $this->clienteRepository->create([
                'id_usuario_creacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'],
                'apellido_paterno' => $data['apellidoPaterno'],
                'apellido_materno' => $data['apellidoMaterno'] ?? '',
                'telefono' => $data['telefono'] ?? null,
                'telefono_celular' => $data['telefonoCelular'] ?? null,
                'activo' => true
            ]);

            DB::commit();

            return $cliente;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al registrar cliente');            
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al registrar cliente');
        }
    }

    /**
     * Actualiza los datos de un cliente existente
     *
     * @param int $id ID del cliente a actualizar
     * @param array $data Campos a actualizar (todos opcionales):
     *               - nombre (string)
     *               - apellido_paterno (string)
     *               - apellido_materno (string)
     *               - telefono (string)
     *               - telefono_celular (string)
     * @return Cliente El cliente con los datos actualizados
     * @throws HttpException Si el cliente no existe o hay un error en la actualización
     */
    public function update($id, $data)
    {
        try {
            $cliente = $this->getClientById($id);

            DB::beginTransaction();

            $cliente = $this->clienteRepository->update($cliente, [
                'id_usuario_actualizacion' => auth()->id() ?? 1,
                'nombre' => $data['nombre'] ?? $cliente->nombre,
                'apellido_paterno' => $data['apellidoPaterno'] ?? $cliente->apellido_paterno,
                'apellido_materno' => $data['apellidoMaterno'] ?? $cliente->apellido_materno,
                'telefono' => $data['telefono'] ?? $cliente->telefono,
                'telefono_celular' => $data['telefonoCelular'] ?? $cliente->telefono_celular,
            ]);

            DB::commit();

            return $cliente;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al actualizar cliente');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al actualizar cliente');
        }
    }

    /**
     * Elimina un cliente del sistema (soft delete)
     *
     * @param int $id ID del cliente a eliminar
     * @return bool True si la eliminación fue exitosa
     * @throws HttpException Si el cliente no existe o hay un error al eliminar
     */
    public function delete($id)
    {
        try {

            $cliente = $this->getClientById($id);

            DB::beginTransaction();

            $cliente = $this->clienteRepository->delete($cliente);

            DB::commit();

            return $cliente;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al eliminar cliente');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al eliminar cliente');
        }
    }

    /**
     * Obtiene un cliente específico por su ID
     *
     * @param int $id ID del cliente a buscar
     * @return Cliente El cliente encontrado
     * @throws HttpException Si el cliente no existe o hay un error en la consulta
     */
    public function getClientById($id)
    {
        try {            
            $cliente = $this->clienteRepository->findById($id);

            if (!$cliente) {
                $this->handleNotFound('No se encontró el cliente');
            }

            return $cliente;

        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar cliente');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar cliente');
        }
    }

    /**
     * Obtiene todos los clientes registrados en el sistema
     *
     * @return \Illuminate\Database\Eloquent\Collection Lista de todos los clientes
     * @throws HttpException Si hay un error al obtener los datos
     */
    public function getAll()
    {
        try {
            return $this->clienteRepository->getAll();           
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de clientes');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar todos los clientes');
        }
    }
}
