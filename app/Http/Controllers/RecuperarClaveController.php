<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecuperarClaveRequest;
use App\Models\Usuario;
use App\Services\CodigoRecuperacionService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoRecuperacionMail;
use Throwable;

class RecuperarClaveController extends Controller
{
    protected $codigoRecuperacionService;

    public function __construct(CodigoRecuperacionService $codigoRecuperacionService)
    {
        $this->codigoRecuperacionService = $codigoRecuperacionService;
    }

    public function __invoke(RecuperarClaveRequest $request)
    {
        try {
            // Buscar al usuario
            $usuario = Usuario::where('usuario', $request->usuario)->first();

            // Generar código de 6 dígitos
            $codigo = $this->codigoRecuperacionService->generarCodigo($usuario->id);

            // Enviar correo con el código
            Mail::to($usuario->usuario)->send(new CodigoRecuperacionMail($codigo));

            return response()->json([
                'success' => true,
                'message' => 'Se ha enviado un código de recuperación a tu correo electrónico.'
            ]);

        } catch (Throwable $e) {
            return $this->handleErrors($e, 'Recuperación de clave');
        }
    }
}