<?php

namespace App\Repositories;

use App\Models\Perfil;
use App\Models\PerfilPrivilegio;

/**
 * Repositorio para la gestión de operaciones CRUD de perfiles
 * 
 * Implementa PerfilRepositoryInterface y proporciona métodos para:
 * - Gestión básica de perfiles (CRUD)
 * - Asignación y eliminación de privilegios
 */
class PerfilRepository implements PerfilRepositoryInterface
{
    /**
     * Crea un nuevo perfil en el sistema
     * 
     * @param array $data Datos del perfil a crear
     * @return Perfil El perfil recién creado
     */
    public function create(array $data): Perfil
    {
        return Perfil::create($data);
    }

    /**
     * Actualiza los datos de un perfil existente
     * 
     * @param Perfil $perfil Instancia del perfil a actualizar
     * @param array $data Nuevos datos para el perfil
     * @return Perfil El perfil con los datos actualizados
     */
    public function update(Perfil $perfil, array $data): Perfil
    {
        $perfil->update($data);
        return $perfil->fresh();
    }

    /**
     * Elimina un perfil del sistema
     * 
     * @param Perfil $perfil Instancia del perfil a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function delete(Perfil $perfil): bool
    {
        return $perfil->delete();
    }

    /**
     * Busca un perfil por su ID
     * 
     * @param int $id ID del perfil a buscar
     * @return Perfil|null El perfil encontrado o null si no existe
     */
    public function findById(int $id): ?Perfil
    {
        return Perfil::find($id);
    }

    /**
     * Obtiene todos los perfiles del sistema
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los perfiles
     */
    public function getAll()
    {
        return Perfil::all();
    }

    /**
     * Elimina todos los privilegios asignados a un perfil
     * 
     * @param Perfil $perfil Instancia del perfil a limpiar
     * @return void
     */
    public function eliminarPrivilegios(Perfil $perfil): void
    {
        $perfil->privilegios()->delete();
    }

    /**
     * Asigna múltiples privilegios a un perfil
     * 
     * @param int $idPerfil ID del perfil al que se asignarán los privilegios
     * @param array $privilegios Array de privilegios a asignar
     * @return void
     * 
     * @example Ejemplo de estructura de $privilegios:
     * [
     *     ['idPrivilegio' => 1],
     *     ['idPrivilegio' => 3]
     * ]
     */
    public function asignarPrivilegios(int $idPerfil, array $privilegios): void
    {
        foreach ($privilegios as $privilegio) {
            PerfilPrivilegio::create([
                'id_usuario_creacion' => auth()->id() ?? 1,
                'id_perfil' => $idPerfil,
                'id_menu' => $privilegio['idPrivilegio']
            ]);
        }
    }
}