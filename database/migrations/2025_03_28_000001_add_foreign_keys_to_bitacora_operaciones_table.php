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
        Schema::table('bitacora_operaciones', function (Blueprint $table) {
            // Definir la relación con la tabla 'usuarios'
            $table->foreign('id_usuario')->references('id')->on('usuarios')
                ->onUpdate('no action') // Acción en caso de actualización
                ->onDelete('cascade'); // Acción en caso de eliminación (puedes cambiar esto según tus necesidades)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bitacora_operaciones', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });
    }
};
