<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plantillas_asuntos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('plantilla');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->comment('Tabla para almacenar plantillas de asuntos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plantillas_asuntos');
    }
};