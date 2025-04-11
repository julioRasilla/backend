<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario_creacion');
            $table->bigInteger('id_usuario_actualizacion')->nullable();
            $table->bigInteger('id_perfil');
            $table->bigInteger('id_empleado')->nullable();
            $table->bigInteger('id_cliente')->nullable();
            $table->string('usuario')->unique('usuarios_nombre_usuario_unico');
            $table->text('clave');
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrent();
            $table->remember_token();
            $table->integer('id_tipo_usuario')->comment('1  Usuario del sistema (Empleado) 2 Usuario cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
