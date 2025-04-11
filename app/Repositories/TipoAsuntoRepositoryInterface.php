<?php

namespace App\Repositories;

use App\Models\TipoAsunto;

interface TipoAsuntoRepositoryInterface
{
    public function create(array $data);
    public function update(TipoAsunto $tipoAsunto, array $data);
    public function delete(TipoAsunto $tipoAsunto);
    public function findById($id);
    public function getAll();
}