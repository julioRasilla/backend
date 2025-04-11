<?php

namespace App\Repositories;

use App\Models\InstruccionPago;

interface InstruccionPagoRepositoryInterface
{
    public function create(array $data);
    public function update(InstruccionPago $instruccionPago, array $data);
    public function delete(InstruccionPago $instruccionPago);
    public function findById($id);
    public function getAll();
}