<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bitacora_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario'); // Ahora es requerido
            $table->string('usuario');
            $table->string('ip', 45)->default('');
            $table->json('dato'); // Se guarda como JSON
            $table->timestamp('fecha_creacion')->default(now());

            // Definir la clave foránea con eliminación en cascada
            $table->foreign('id_usuario')->references('id')->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacora_sistemas');
    }
};
