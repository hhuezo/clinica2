<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('medico_id')->constrained('medicos')->cascadeOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->dateTime('fecha_programada');
            $table->unsignedSmallInteger('duracion_minutos')->default(30);
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'en_progreso',
                'completada',
                'cancelada',
                'no_asistio',
            ])->default('pendiente');
            $table->string('motivo')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['medico_id', 'fecha_programada']);
            $table->index(['sucursal_id', 'fecha_programada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
