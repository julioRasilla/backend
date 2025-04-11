<?php

namespace App\Repositories;

use App\Models\PlantillaAsunto;

class PlantillaAsuntoRepository implements PlantillaAsuntoRepositoryInterface
{
    public function create(array $data)
    {
        return PlantillaAsunto::create($data);
    }

    public function update(PlantillaAsunto $plantillaAsunto, array $data)
    {
        $plantillaAsunto->update($data);
        return $plantillaAsunto->fresh();
    }

    public function delete(PlantillaAsunto $plantillaAsunto)
    {
        return $plantillaAsunto->delete();
    }

    public function findById($id)
    {
        return PlantillaAsunto::find($id);
    }

    public function getAll()
    {
        return PlantillaAsunto::all();
    }
}