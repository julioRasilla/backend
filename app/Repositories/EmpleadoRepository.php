<?php

namespace App\Repositories;

use App\Models\Empleado;

/**
 * Repositorio para la gestión de empleados
 * 
 * Implementa las operaciones CRUD básicas para el modelo Empleado
 */
class EmpleadoRepository implements EmpleadoRepositoryInterface
{
    /**
     * Crea un nuevo empleado
     * 
     * @param array $data Datos del empleado a crear
     * @return Empleado El empleado recién creado
     */
    public function create(array $data)
    {
        return Empleado::create($data);
    }

    /**
     * Actualiza los datos de un empleado existente
     * 
     * @param Empleado $empleado Instancia del empleado a actualizar
     * @param array $data Nuevos datos para el empleado
     * @return Empleado El empleado actualizado
     */
    public function update(Empleado $empleado, array $data)
    {
        $empleado->update($data);
        return $empleado->fresh();
    }

    /**
     * Elimina un empleado
     * 
     * @param Empleado $empleado Instancia del empleado a eliminar
     * @return bool Resultado de la operación (true si fue exitosa)
     */
    public function delete(Empleado $empleado)
    {
        return $empleado->delete();
    }

    /**
     * Busca un empleado por su ID
     * 
     * @param int $id ID del empleado a buscar
     * @return Empleado|null El empleado encontrado o null si no existe
     */
    public function findById($id)
    {
        return Empleado::find($id);
    }

    /**
     * Obtiene todos los empleados
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los empleados
     */
    public function getAll()
    {
        return Empleado::all();
    }
}