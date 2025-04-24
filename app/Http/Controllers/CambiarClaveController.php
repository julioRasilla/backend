<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarClaveRequest;
use App\Models\Usuario;
use App\Services\CodigoRecuperacionService;
use Illuminate\Support\Facades\Hash;
use Throwable;

class CambiarClaveController extends Controller
{
    protected $codigoRecuperacionService;

    public function __construct(CodigoRecuperacionService $codigoRecuperacionService)
    {
        $this->codigoRecuperacionService = $codigoRecuperacionService;
    }

    public function __invoke(CambiarClaveRequest $request)
    {
        try {
            // Buscar al usuario
            $usuario = Usuario::where('usuario', $request->usuario)->first();

            // Validar el código
            $codigoValido = $this->codigoRecuperacionService->validarCodigo(
                $usuario->id, 
                $request->codigo
            );

            if (!$codigoValido) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código de recuperación es inválido o ha expirado.'
                ], 400);
            }

            // Actualizar la contraseña
            $usuario->clave = Hash::make($request->nueva_clave);
            $usuario->save();

            // Eliminar el código usado
            $this->codigoRecuperacionService->eliminarCodigo($usuario->id);

            return response()->json([
                'success' => true,
                'message' => 'Tu contraseña ha sido actualizada correctamente.'
            ]);

        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Cambio de clave');
        }
    }
}