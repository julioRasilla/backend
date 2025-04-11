<?php

namespace App\Repositories;

use App\Models\Empleado;

/**
 * Interfaz para el repositorio de Empleados
 * 
 * Define el contrato que debe implementar cualquier repositorio de empleados,
 * estableciendo los métodos básicos para la gestión de empleados.
 */
interface EmpleadoRepositoryInterface
{
    /**
     * Crea un nuevo registro de empleado
     * 
     * @param array $data Datos del empleado a crear
     * @return Empleado El empleado recién creado
     */
    public function create(array $data);

    /**
     * Actualiza los datos de un empleado existente
     * 
     * @param Empleado $empleado Instancia del empleado a actualizar
     * @param array $data Nuevos datos para el empleado
     * @return Empleado El empleado actualizado
     */
    public function update(Empleado $empleado, array $data);

    /**
     * Elimina un empleado del sistema
     * 
     * @param Empleado $empleado Instancia del empleado a eliminar
     * @return bool Resultado de la operación (true si fue exitosa)
     */
    public function delete(Empleado $empleado);

    /**
     * Busca un empleado por su ID
     * 
     * @param int $id ID del empleado a buscar
     * @return Empleado|null El empleado encontrado o null si no existe
     */
    public function findById($id);

    /**
     * Obtiene todos los empleados registrados
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los empleados
     */
    public function getAll();
}