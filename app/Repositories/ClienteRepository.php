<?php

namespace App\Repositories;

use App\Models\Cliente;

/**
 * Repositorio para la gestión de operaciones CRUD de clientes
 * 
 * Implementa la interfaz ClienteRepositoryInterface y proporciona
 * métodos para interactuar con la entidad Cliente.
 */
class ClienteRepository implements ClienteRepositoryInterface
{
    /**
     * Crea un nuevo cliente en la base de datos
     * 
     * @param array $data Datos del cliente a crear
     * @return Cliente El modelo Cliente creado
     */
    public function create(array $data)
    {
        return Cliente::create($data);
    }

    /**
     * Actualiza los datos de un cliente existente
     * 
     * @param Cliente $cliente Instancia del cliente a actualizar
     * @param array $data Nuevos datos del cliente
     * @return Cliente El modelo Cliente actualizado
     */
    public function update(Cliente $cliente, array $data)
    {
        $cliente->update($data);
        return $cliente->fresh();
    }

    /**
     * Elimina un cliente de la base de datos
     * 
     * @param Cliente $cliente Instancia del cliente a eliminar
     * @return bool Resultado de la operación de eliminación
     */
    public function delete(Cliente $cliente)
    {
        return $cliente->delete();
    }

    /**
     * Busca un cliente por su ID
     * 
     * @param int $id ID del cliente a buscar
     * @return Cliente|null El modelo Cliente encontrado o null
     */
    public function findById($id)
    {
        return Cliente::find($id);
    }

    /**
     * Obtiene todos los clientes registrados
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los clientes
     */
    public function getAll()
    {
        return Cliente::all();
    }
}