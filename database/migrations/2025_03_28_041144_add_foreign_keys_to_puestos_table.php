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
        Schema::table('puestos', function (Blueprint $table) {
            $table->foreign(['id_usuario_actualizacion'], 'puestos_usuarios_id_usuario_actualizacion_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_creacion'], 'puestos_usuarios_id_usuario_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            $table->dropForeign('puestos_usuarios_id_usuario_actualizacion_fk');
            $table->dropForeign('puestos_usuarios_id_usuario_fk');
        });
    }
};
