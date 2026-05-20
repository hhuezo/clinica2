<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('especialidad')->nullable();
            $table->string('numero_colegiado', 50)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->text('biografia')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('medico_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->foreignId('medico_id')->constrained('medicos')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['sucursal_id', 'medico_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medico_sucursal');
        Schema::dropIfExists('medicos');
    }
};
