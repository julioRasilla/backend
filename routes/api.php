<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TipoAsuntoController;
use App\Http\Controllers\InstruccionPagoController;
use App\Http\Controllers\PlantillaAsuntoController;

use App\Models\Usuario;

// Rutas públicas (sin autenticación)
Route::controller(UsuarioController::class)->group(function () {
    //  Route::post('/usuarios/clientes/registro', 'registroUsuarioCliente')->name("Registro de cliente");
    Route::post('/usuarios', 'store')->name("Registro de usuario");
    Route::post('/login', 'login')->name("Iniciar sesión");
});
Route::post('/clientes', [ClienteController::class, 'store'])->name("Registrar cliente");



// Rutas protegidas (requieren Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UsuarioController::class, 'user']);
    Route::post('/cerrar-sesion', [UsuarioController::class, 'logOut'])->name("Cerrar sesión");

    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name("Consulta todos los usuarios");
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('Actualizar usuario');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('Eliminar usuario');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name("Detalle usuario");

    //Usuarios con sus relaciones
    Route::get('usuarios/{id}/detalles', [UsuarioController::class, 'showWithRelations'])->name("Consulta usuario detalles");
    Route::get('usuarios-detalles', [UsuarioController::class, 'indexWithRelations'])->name("Consulta a todos los usuarios detalles"); // ✅ Esto está bien


    //Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->where('id', '[0-9]+')->name('Actualizar usuario');



    // Empleados
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name("Consulta a todos los empleados");
    Route::get('/empleados/{id}', [EmpleadoController::class, 'show'])->name("Consulta un empleado por id");
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name("Registrar empleado");
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name("Actualizar empleado");
    Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name("Eliminar empleado");

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name("Consulta a todos los clientes");
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name("Consulta un cliente por id");
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name("Actualizar cliente");
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name("Eliminar cliente");

    // Clientes
    Route::get('/perfiles', [PerfilController::class, 'index'])->name("Consulta a todos los perfiles");
    Route::get('/perfiles/{id}', [PerfilController::class, 'show'])->name("Consulta un perfil por id");
    Route::post('/perfiles', [PerfilController::class, 'store'])->name("Registrar un perfil");
    Route::put('/perfiles/{id}', [PerfilController::class, 'update'])->name("Actualizar un perfil");
    Route::delete('/perfiles/{id}', [PerfilController::class, 'destroy'])->name("Eliminar perfil");

});

// ... rutas del CRUD tipos-asuntos

Route::prefix('/tipos-asunto')->group(function () {
    Route::post('/', [TipoAsuntoController::class, 'store']);
    Route::put('/{id}', [TipoAsuntoController::class, 'update']);
    Route::delete('/{id}', [TipoAsuntoController::class, 'destroy']);
    Route::get('/{id}', [TipoAsuntoController::class, 'show']);
    Route::get('/', [TipoAsuntoController::class, 'index']);
});

// ... rutas del CRUD instrucciones-pagos

Route::prefix('instrucciones-pago')->group(function () {
    Route::post('/', [InstruccionPagoController::class, 'store']);
    Route::put('/{id}', [InstruccionPagoController::class, 'update']);
    Route::delete('/{id}', [InstruccionPagoController::class, 'destroy']);
    Route::get('/{id}', [InstruccionPagoController::class, 'show']);
    Route::get('/', [InstruccionPagoController::class, 'index']);
});

// rutas del CRUD plantillas-asuntos

Route::prefix('plantillas-asunto')->group(function () {
    Route::post('/', [PlantillaAsuntoController::class, 'store']);
    Route::put('/{id}', [PlantillaAsuntoController::class, 'update']);
    Route::delete('/{id}', [PlantillaAsuntoController::class, 'destroy']);
    Route::get('/{id}', [PlantillaAsuntoController::class, 'show']);
    Route::get('/', [PlantillaAsuntoController::class, 'index']);
});