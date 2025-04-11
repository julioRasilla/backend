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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario_creacion');
            $table->bigInteger('id_usuario_actualizacion')->nullable();
            $table->string('nombre', 30);
            $table->string('apellido_paterno', 30);
            $table->string('apellido_materno', 30)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('telefono_celular', 10)->nullable();
            $table->boolean('activo')->nullable()->default(true);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrent();

            $table->unique(['apellido_paterno', 'apellido_materno', 'nombre'], 'clientes_nombre_completo_unico');
            $table->unique(['nombre', 'apellido_paterno', 'apellido_materno'], 'clientes_nombre_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
