<?php

namespace App\Repositories;

use App\Models\TipoAsunto;

class TipoAsuntoRepository implements TipoAsuntoRepositoryInterface
{
    public function create(array $data)
    {
        return TipoAsunto::create($data);
    }

    public function update(TipoAsunto $tipoAsunto, array $data)
    {
        $tipoAsunto->update($data);
        return $tipoAsunto->fresh();
    }

    public function delete(TipoAsunto $tipoAsunto)
    {
        return $tipoAsunto->delete();
    }

    public function findById($id)
    {
        return TipoAsunto::find($id);
    }

    public function getAll()
    {
        return TipoAsunto::all();
    }
}