<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instrucciones_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->comment('Tabla para almacenar instrucciones de pago');
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrucciones_pagos');
    }
};