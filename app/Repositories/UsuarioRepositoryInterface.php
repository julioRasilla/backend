<?php

namespace App\Repositories;

use App\Models\Usuario;

/**
 * Interfaz que define el contrato para el repositorio de usuarios
 * 
 * Establece los métodos obligatorios para cualquier implementación
 * que gestione la persistencia de usuarios en el sistema.
 */
interface UsuarioRepositoryInterface
{
    /**
     * Debe buscar un usuario por su nombre de usuario
     * 
     * @param string $username Nombre de usuario a buscar (case-sensitive)
     * @return Usuario|null El usuario encontrado o null si no existe
     */
    public function findByUsername(string $username): ?Usuario;

    /**
     * Debe crear un nuevo usuario en el sistema
     * 
     * @param array $data Datos del usuario a crear
     * @return Usuario El usuario recién creado
     * @throws \Illuminate\Database\QueryException Si falla la creación
     */
    public function create(array $data): Usuario;

    /**
     * Debe actualizar los datos de un usuario existente
     * 
     * @param Usuario $usuario Instancia del usuario a actualizar
     * @param array $data Nuevos datos para el usuario
     * @return Usuario El usuario actualizado
     */
    public function update(Usuario $usuario, array $data): Usuario;

    /**
     * Debe eliminar un usuario del sistema
     * 
     * @param Usuario $usuario Instancia del usuario a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function delete(Usuario $usuario): bool;

    /**
     * Debe buscar un usuario por su ID
     * 
     * @param int $id ID del usuario a buscar (debe ser > 0)
     * @return Usuario|null El usuario encontrado o null si no existe
     */
    public function findById(int $id): ?Usuario;

    /**
     * Debe buscar un usuario por ID incluyendo sus relaciones
     * 
     * @param int $id ID del usuario a buscar
     * @return Usuario|null El usuario con relaciones cargadas o null si no existe
     * 
     * @note Las relaciones incluyen: empleado y cliente
     */
    public function findByIdWithRelations(int $id): ?Usuario;

    /**
     * Debe obtener todos los usuarios con paginación
     * 
     * @param int $perPage Número de elementos por página (default: 10)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista paginada de usuarios
     */
    public function getAll(int $perPage = 10);

    /**
     * Debe obtener todos los usuarios con relaciones y paginación
     * 
     * @param int $perPage Número de elementos por página (default: 10)
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista paginada de usuarios con relaciones
     * 
     * @note Las relaciones incluyen: empleado y cliente
     */
    public function getAllWithRelations(int $perPage = 10);
    
    /**
     * Debe obtener el usuario actualmente autenticado
     * 
     * @return Usuario|null El usuario autenticado o null si no hay sesión activa
     */
    public function getAuthenticated(): ?Usuario;
}