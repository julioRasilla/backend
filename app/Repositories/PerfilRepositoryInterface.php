<?php

namespace App\Repositories;

use App\Models\Perfil;

/**
 * Interfaz que define el contrato para el repositorio de perfiles
 * 
 * Establece los métodos obligatorios para cualquier implementación
 * que gestione la persistencia de perfiles y sus privilegios.
 */
interface PerfilRepositoryInterface
{
    /**
     * Debe crear un nuevo registro de perfil
     * 
     * @param array $data Datos del perfil a crear
     * @return Perfil Instancia del perfil creado
     */
    public function create(array $data): Perfil;

    /**
     * Debe actualizar los datos de un perfil existente
     * 
     * @param Perfil $perfil Instancia del perfil a actualizar
     * @param array $data Nuevos datos para el perfil
     * @return Perfil Instancia del perfil actualizado
     */
    public function update(Perfil $perfil, array $data): Perfil;

    /**
     * Debe eliminar un perfil del sistema
     * 
     * @param Perfil $perfil Instancia del perfil a eliminar
     * @return bool True si la eliminación fue exitosa, false en caso contrario
     */
    public function delete(Perfil $perfil): bool;

    /**
     * Debe buscar un perfil por su ID
     * 
     * @param int $id ID del perfil a buscar
     * @return Perfil|null Instancia del perfil encontrado o null si no existe
     */
    public function findById(int $id): ?Perfil;

    /**
     * Debe obtener todos los perfiles registrados
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de perfiles
     */
    public function getAll();

    /**
     * Debe eliminar todos los privilegios asociados a un perfil
     * 
     * @param Perfil $perfil Instancia del perfil cuyos privilegios se eliminarán
     * @return void
     */
    public function eliminarPrivilegios(Perfil $perfil): void;

    /**
     * Debe asignar múltiples privilegios a un perfil
     * 
     * @param int $idPerfil ID del perfil al que se asignarán los privilegios
     * @param array $privilegios Array de privilegios a asignar (estructura definida por implementación)
     * @return void
     */
    public function asignarPrivilegios(int $idPerfil, array $privilegios): void;
}