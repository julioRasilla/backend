<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bitacora_sistemas', function (Blueprint $table) {
            $table->string('funcionalidad')->after('ip')->nullable(); // 🔹 Agregamos el campo después de `ip`
        });
    }

    public function down(): void
    {
        Schema::table('bitacora_sistemas', function (Blueprint $table) {
            $table->dropColumn('funcionalidad');
        });
    }
};
