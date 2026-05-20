<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('empresa_id')->nullable()->after('activo')->constrained('empresas')->nullOnDelete();
            $table->foreignId('clinica_id')->nullable()->after('empresa_id')->constrained('clinicas')->nullOnDelete();
            $table->foreignId('sucursal_id')->nullable()->after('clinica_id')->constrained('sucursales')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sucursal_id');
            $table->dropConstrainedForeignId('clinica_id');
            $table->dropConstrainedForeignId('empresa_id');
        });
    }
};
