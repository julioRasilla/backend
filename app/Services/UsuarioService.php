<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\LogSistema;
use Throwable;

/**
 * Servicio para gestionar operaciones relacionadas con usuarios
 * 
 * Proporciona métodos para autenticación, creación, actualización, 
 * eliminación y consulta de usuarios, manejando transacciones de base de datos
 * y errores de manera consistente.
 */
class UsuarioService extends BaseService
{
    /**
     * Repositorio de usuarios
     *
     * @var UsuarioRepositoryInterface
     */
    protected UsuarioRepositoryInterface $usuarioRepository;

    /**
     * Constructor de la clase UsuarioService
     *
     * @param UsuarioRepositoryInterface $usuarioRepository Repositorio de usuarios
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }
    /**
     * Autentica un usuario y genera token de acceso
     *
     * @param array $datos Credenciales de autenticación:
     *               - usuario (string): Nombre de usuario
     *               - clave (string): Contraseña en texto plano
     * @return array Estructura con token y datos básicos del usuario
     * @throws ValidationException Si las credenciales son inválidas
     * @throws HttpException Si ocurre un error durante el proceso
     */
    public function authenticate($datos)
    {
        try {
            $usuario = $this->usuarioRepository->findByUsername($datos['usuario']);

            if (!$usuario || !Hash::check($datos['clave'], $usuario->clave)) {
                throw ValidationException::withMessages([
                    'usuario' => ['Las credenciales son incorrectas.'],
                ]);
            }

            return [
                'idUsuario' => $usuario->id,
                'usuario' => $usuario->usuario,
                'token' => $usuario->createToken('auth_token')->plainTextToken
            ];

        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            LogSistema::registrar([
                'UsuarioService' => 'Error en autenticación',
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                json_encode($this->errorArray(Response::HTTP_INTERNAL_SERVER_ERROR, "Error en el inicio de sesión"))
            );
        }
    }

    /**
     * Crea un nuevo usuario en el sistema
     *
     * @param array $data Datos del usuario a crear:
     *               - usuario (string): Nombre de usuario (requerido)
     *               - clave (string): Contraseña (requerido)
     *               - id_tipo_usuario (int): Tipo de usuario (requerido)
     *               - id_perfil (int): Perfil (requerido)
     *               - id_empleado (int|null): ID empleado asociado (opcional)
     *               - id_cliente (int|null): ID cliente asociado (opcional)
     * @return Usuario El usuario recién creado
     * @throws HttpException Si ocurre un error durante la creación
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->create([
                'id_usuario_creacion' => auth()->id() ?? 1,
                'usuario' => $data['usuario'],
                'clave' => Hash::make($data['clave']),
                'id_tipo_usuario' => $data['idTipoUsuario'],
                'id_perfil' => $data['idPerfil'],
                'id_empleado' => $data['idEmpleado'] ?? null,
                'id_cliente' => $data['idCliente'] ?? null,
                'activo' => true
            ]);

            DB::commit();

            return $usuario;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al registrar usuario');
        } catch (Throwable $e) {
            DB::rollBack();
            
            $this->handleThrowable($e, 'Error desconocido al registrar usuario');
        }
    }

    /**
     * Actualiza un usuario existente
     *
     * @param int $id ID del usuario a actualizar
     * @param array $data Campos a actualizar (todos opcionales):
     *               - usuario (string)
     *               - clave (string)
     *               - id_tipo_usuario (int)
     *               - id_perfil (int)
     *               - id_empleado (int|null)
     *               - id_cliente (int|null)
     *               - activo (bool)
     * @return Usuario El usuario actualizado
     * @throws HttpException Si el usuario no existe o hay error en la actualización
     */
    public function update(int $id, array $data): Usuario
    {
        try {
            $usuario = $this->getUserById($id);

            DB::beginTransaction();

            $updateData = [
                'id_usuario_actualizacion' => auth()->id() ?? 1,
                'usuario' => $data['usuario'] ?? $usuario->usuario,
                'id_tipo_usuario' => $data['idTipoUsuario'] ?? $usuario->id_tipo_usuario,
                'id_perfil' => $data['idPerfil'] ?? $usuario->id_perfil,
                'id_empleado' => $data['idEmpleado'] ?? $usuario->id_empleado,
                'id_cliente' => $data['idCliente'] ?? $usuario->id_cliente,
                'activo' => $data['activo'] ?? $usuario->activo
            ];

            $usuario = $this->usuarioRepository->update($usuario, $updateData);

            DB::commit();

            return $usuario;

        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al actualizar usuario');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al actualizar usuario');
        }
    }

    /**
     * Elimina un usuario (soft delete)
     *
     * @param int $id ID del usuario a eliminar
     * @return bool True si la eliminación fue exitosa
     * @throws HttpException Si el usuario no existe o hay error al eliminar
     */
    public function delete(int $id)
    {
        try {
            $usuario = $this->getUserById($id);

            DB::beginTransaction();

            $this->usuarioRepository->delete($usuario);

            DB::commit();

            return $usuario;
            
        } catch (QueryException $e) {
            DB::rollBack();

            $this->handleQueryException($e, 'Error al eliminar usuario');
        } catch (Throwable $e) {
            DB::rollBack();

            $this->handleThrowable($e, 'Error desconocido al eliminar usuario');
        }
    }

    /**
     * Obtiene un usuario específico por su ID
     *
     * @param int $id ID del usuario a buscar
     * @return Usuario El usuario encontrado
     * @throws HttpException Si el usuario no existe o hay un error en la consulta
     */
    public function getUserById($id)
    {
        try {
            $usuario = $this->usuarioRepository->findById($id);

            if (!$usuario) {
                $this->handleNotFound('Usuario no encontrado');
            }

            return $usuario;
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar usuario');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar usuario');
        }
    }

    /**
     * Obtiene un usuario específico y sus relaciones por su ID
     *
     * @param int $id ID del usuario a buscar
     * @return Usuario El usuario encontrado
     * @throws HttpException Si el usuario no existe o hay un error en la consulta
     */
    public function getUserByIdWithRelations($id)
    {
        try {
            $usuario = $this->usuarioRepository->findByIdWithRelations($id);

            if (!$usuario) {
                $this->handleNotFound('Usuario no encontrado');
            }

            return $usuario;
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al consultar usuario');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al consultar usuario');
        }
    }

    /**
     * Obtiene todos los usuarios registrados en el sistema
     *
     * @param int $perPage Cantidad de resultados por página (opcional)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista de usuarios paginada
     * @throws HttpException Si hay un error al obtener los datos
     */
    public function getAll($perPage = 10)
    {
        try {
            return $this->usuarioRepository->getAll($perPage);
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de usuarios');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar usuarios');
        }
    }

    /**
     * Obtiene todos los usuarios registrados en el sistema (con relaciones)
     *
     * @param int $perPage Cantidad de resultados por página (opcional)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista de usuarios paginada
     * @throws HttpException Si hay un error al obtener los datos
     */
    public function getAllWithRelations($perPage = 10)
    {
        try {
            return $this->usuarioRepository->getAllWithRelations($perPage);
        } catch (QueryException $e) {
            $this->handleQueryException($e, 'Error al obtener lista de usuarios');
        } catch (Throwable $e) {
            $this->handleThrowable($e, 'Error desconocido al listar usuarios');
        }
    }

    /**
     * Obtiene el usuario actualmente autenticado
     * 
     * @return Usuario Modelo del usuario autenticado
     * @throws \Exception Si no hay usuario autenticado (HTTP 401)
     */
    public function getAuthenticatedUser()
    {
        try {
            return $this->usuarioRepository->getAuthenticated();
        } catch (Throwable $e) {
            return $this->handleThrowable($e, 'No se pudo obtener el usuario autenticado');
        }
    }
}
