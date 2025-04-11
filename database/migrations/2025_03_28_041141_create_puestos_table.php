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
        Schema::create('puestos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario_creacion');
            $table->bigInteger('id_usuario_actualizacion')->nullable();
            $table->bigInteger('id_categoria');
            $table->string('titulo', 35)->unique('puestos_titulo_unico');
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_creacion')->nullable()->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};
