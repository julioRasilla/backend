<?php

namespace App\Services;

use App\Models\CodigoRecuperacion;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CodigoRecuperacionService
{
    public function generarCodigo($usuarioId)
    {
        // Eliminar códigos anteriores del usuario
        CodigoRecuperacion::where('usuario_id', $usuarioId)->delete();

        // Generar nuevo código de 6 dígitos
        $codigo = strtoupper(Str::random(6));

        // Guardar en base de datos
        $codigoRecuperacion = CodigoRecuperacion::create([
            'usuario_id' => $usuarioId,
            'codigo' => $codigo,
            'fecha_expiracion' => Carbon::now()->addHours(2)
        ]);

        return $codigo;
    }

    public function validarCodigo($usuarioId, $codigo)
    {
        $codigoRecuperacion = CodigoRecuperacion::where([
            'usuario_id' => $usuarioId,
            'codigo' => $codigo
        ])->first();

        if (!$codigoRecuperacion) {
            return false;
        }

        if (Carbon::now()->gt($codigoRecuperacion->fecha_expiracion)) {
            return false;
        }

        return true;
    }

        public function eliminarCodigo($usuarioId)
    {
        CodigoRecuperacion::where('usuario_id', $usuarioId)->delete();
    }
}