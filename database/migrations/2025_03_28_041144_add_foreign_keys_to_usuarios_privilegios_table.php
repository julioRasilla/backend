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
        Schema::table('usuarios_privilegios', function (Blueprint $table) {
            $table->foreign(['id'], 'usuarios_privilegios_menus_fk')->references(['id'])->on('menus')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_actualizacion'], 'usuarios_privilegios_usuarios_id_usuario_actualizacion_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_creacion'], 'usuarios_privilegios_usuarios_id_usuario_creacion')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario'], 'usuarios_privilegios_usuarios_id_usuario_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios_privilegios', function (Blueprint $table) {
            $table->dropForeign('usuarios_privilegios_menus_fk');
            $table->dropForeign('usuarios_privilegios_usuarios_id_usuario_actualizacion_fk');
            $table->dropForeign('usuarios_privilegios_usuarios_id_usuario_creacion');
            $table->dropForeign('usuarios_privilegios_usuarios_id_usuario_fk');
        });
    }
};
