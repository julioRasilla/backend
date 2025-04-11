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
        Schema::create('usuarios_privilegios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario_creacion');
            $table->bigInteger('id_usuario_actualizacion')->nullable();
            $table->bigInteger('id_usuario');
            $table->bigInteger('id_menu');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrent();

            $table->unique(['id_usuario', 'id_menu'], 'usuarios_privilegios_usuario_privilegio_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_privilegios');
    }
};
