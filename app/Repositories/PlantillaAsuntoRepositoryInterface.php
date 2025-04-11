<?php

namespace App\Repositories;

use App\Models\PlantillaAsunto;

interface PlantillaAsuntoRepositoryInterface
{
    public function create(array $data);
    public function update(PlantillaAsunto $plantillaAsunto, array $data);
    public function delete(PlantillaAsunto $plantillaAsunto);
    public function findById($id);
    public function getAll();
}