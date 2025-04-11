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
        Schema::create('menus', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->bigInteger('id_usuario_creacion');
            $table->bigInteger('id_usuario_actualizacion')->nullable();
            $table->string('etiqueta', 30);
            $table->string('icono', 30)->nullable();
            $table->integer('padre')->nullable();
            $table->integer('hijo')->nullable();
            $table->string('url', 100);
            $table->smallInteger('orden')->nullable();
            $table->integer('accion')->nullable();
            $table->boolean('visible')->default(true);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
