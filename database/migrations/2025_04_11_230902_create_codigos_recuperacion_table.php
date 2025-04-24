<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codigos_recuperacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->string('codigo', 6);
            $table->timestamp('fecha_expiracion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigos_recuperacion');
    }
};