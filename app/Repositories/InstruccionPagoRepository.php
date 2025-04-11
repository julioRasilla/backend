<?php

namespace App\Repositories;

use App\Models\InstruccionPago;

class InstruccionPagoRepository implements InstruccionPagoRepositoryInterface
{
    public function create(array $data)
    {
        return InstruccionPago::create([
            'nombre' => $data['nombre'],
            // No es necesario añadir las fechas manualmente
        ]);
    }

    public function update(InstruccionPago $instruccionPago, array $data)
    {
        $instruccionPago->update($data);
        return $instruccionPago->fresh();
    }

    public function delete(InstruccionPago $instruccionPago)
    {
        return $instruccionPago->delete();
    }

    public function findById($id)
    {
        return InstruccionPago::find($id);
    }

    public function getAll()
    {
        return InstruccionPago::all();
    }
}