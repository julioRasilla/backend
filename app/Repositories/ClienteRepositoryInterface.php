<?php

namespace App\Repositories;

use App\Models\Cliente;

/**
 * Interfaz que define el contrato para el repositorio de clientes
 * 
 * Establece los métodos obligatorios que deben implementar
 * todas las clases que gestionen operaciones CRUD de clientes.
 */
interface ClienteRepositoryInterface
{
    /**
     * Define el método para crear un nuevo cliente
     * 
     * @param array $data Datos del cliente a crear
     * @return Cliente El modelo Cliente creado
     */
    public function create(array $data);

    /**
     * Define el método para actualizar un cliente existente
     * 
     * @param Cliente $cliente Instancia del cliente a actualizar
     * @param array $data Nuevos datos del cliente
     * @return Cliente El modelo Cliente actualizado
     */
    public function update(Cliente $cliente, array $data);

    /**
     * Define el método para eliminar un cliente
     * 
     * @param Cliente $cliente Instancia del cliente a eliminar
     * @return bool Resultado de la operación (éxito/fracaso)
     */
    public function delete(Cliente $cliente);

    /**
     * Define el método para buscar un cliente por su ID
     * 
     * @param int $id ID del cliente a buscar
     * @return Cliente|null El cliente encontrado o null si no existe
     */
    public function findById($id);

    /**
     * Define el método para obtener todos los clientes
     * 
     * @return \Illuminate\Database\Eloquent\Collection Colección de todos los clientes
     */
    public function getAll();
}