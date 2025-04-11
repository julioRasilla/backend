<?php

namespace App\Repositories;

use App\Models\Usuario;

/**
 * Repositorio para la gestión de operaciones de usuarios
 *
 * Implementa UsuarioRepositoryInterface y proporciona métodos para:
 * - Búsqueda de usuarios por diferentes criterios
 * - Operaciones CRUD básicas
 * - Gestión de relaciones con empleados y clientes
 * - Manejo de usuarios autenticados
 */
class UsuarioRepository implements UsuarioRepositoryInterface
{
    /**
     * Busca un usuario por su nombre de usuario
     *
     * @param string $username Nombre de usuario a buscar
     * @return Usuario|null Modelo Usuario encontrado o null si no existe
     */
    public function findByUsername(string $username): ?Usuario
    {
        return Usuario::where('usuario', $username)->first();
    }

    /**
     * Crea un nuevo usuario en el sistema
     *
     * @param array $data Datos del usuario a crear
     * @return Usuario Modelo Usuario recién creado
     * @throws \Illuminate\Database\QueryException Si falla la creación
     */
    public function create(array $data): Usuario
    {
        return Usuario::create($data);
    }

    /**
     * Actualiza los datos de un usuario existente
     *
     * @param Usuario $usuario Instancia del usuario a actualizar
     * @param array $data Nuevos datos para el usuario
     * @return Usuario Modelo Usuario actualizado
     */
    public function update(Usuario $usuario, array $data): Usuario
    {
        $usuario->update($data);
        return $usuario->fresh();
    }

    /**
     * Elimina un usuario del sistema
     *
     * @param Usuario $usuario Instancia del usuario a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function delete(Usuario $usuario): bool
    {
        return $usuario->delete();
    }

    /**
     * Busca un usuario por su ID
     *
     * @param int $id ID del usuario a buscar
     * @return Usuario|null Modelo Usuario encontrado o null si no existe
     */
    public function findById(int $id): ?Usuario
    {
        return Usuario::find($id);
    }

    /**
     * Busca un usuario por ID incluyendo sus relaciones con empleado y cliente
     *
     * @param int $id ID del usuario a buscar
     * @return Usuario|null Modelo Usuario con relaciones cargadas o null si no existe
     */
    public function findByIdWithRelations(int $id): ?Usuario
    {
        return Usuario::with(['empleado', 'cliente'])->find($id);
    }

    /**
     * Obtiene todos los usuarios con paginación
     *
     * @param int $perPage Número de elementos por página (default: 10)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista paginada de usuarios
     */
    public function getAll(int $perPage = 10)
    {
        return Usuario::paginate($perPage);
    }

    /**
     * Obtiene todos los usuarios con sus relaciones y paginación
     *
     * @param int $perPage Número de elementos por página (default: 10)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista paginada de usuarios con relaciones
     */
    public function getAllWithRelations(int $perPage = 10)
    {
        return Usuario::with(['empleado', 'cliente'])->paginate($perPage);
    }

    /**
     * Obtiene el usuario actualmente autenticado
     *
     * @return Usuario|null Modelo Usuario autenticado o null si no hay sesión
     */
    public function getAuthenticated(): ?Usuario
    {
        return auth()->user();
    }
}