<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_operaciones', function (Blueprint $table) {
            $table->id(); // ID de la operación
            $table->unsignedBigInteger('id_usuario'); // ID del usuario que realiza la operación
            $table->string('ip_usuario', 45); // Dirección IP del usuario
            $table->string('usuario', 100); // Nombre de usuario
            $table->string('funcionalidad', 255); // Funcionalidad ejecutada
            $table->string('accion', 50); // Acción realizada (crear, editar, eliminar, etc.)
            $table->json('datos'); // Datos relacionados con la operación (cambiado a tipo JSON)
            $table->timestamp('fecha_hora_creacion')->useCurrent(); // Fecha y hora de la creación del registro

            // Definir la relación con la tabla 'usuarios'
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora_operaciones');
    }
};
