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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign(['id_cliente'], 'usuarios_clientes_id_cliente_fk')->references(['id'])->on('clientes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_empleado'], 'usuarios_empleados_id_empleado_fk')->references(['id'])->on('empleados')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_perfil'], 'usuarios_perfiles_id_perfil_fk')->references(['id'])->on('perfiles')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_clientes_id_cliente_fk');
            $table->dropForeign('usuarios_empleados_id_empleado_fk');
            $table->dropForeign('usuarios_perfiles_id_perfil_fk');
        });
    }
};
