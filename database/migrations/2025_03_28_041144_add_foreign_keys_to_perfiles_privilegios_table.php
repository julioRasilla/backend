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
        Schema::table('perfiles_privilegios', function (Blueprint $table) {
            $table->foreign(['id_menu'], 'perfiles_privilegios_menus_id_menu_fk')->references(['id'])->on('menus')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_perfil'], 'perfiles_privilegios_perfiles_id_perfil_fk')->references(['id'])->on('perfiles')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_actualizacion'], 'perfiles_privilegios_usuarios_id_usuario_actualizacion_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_creacion'], 'perfiles_privilegios_usuarios_id_usuario_creacion_fk')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfiles_privilegios', function (Blueprint $table) {
            $table->dropForeign('perfiles_privilegios_menus_id_menu_fk');
            $table->dropForeign('perfiles_privilegios_perfiles_id_perfil_fk');
            $table->dropForeign('perfiles_privilegios_usuarios_id_usuario_actualizacion_fk');
            $table->dropForeign('perfiles_privilegios_usuarios_id_usuario_creacion_fk');
        });
    }
};
