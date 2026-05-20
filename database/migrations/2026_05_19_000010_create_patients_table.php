<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique()->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['M', 'F', 'O'])->default('O');
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento');
            $table->string('numero_documento', 50);
            $table->foreignId('pais_id')->nullable()->constrained('paises')->nullOnDelete();
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->nullOnDelete();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->nullOnDelete();
            $table->text('direccion')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('correo')->nullable();
            $table->boolean('es_menor')->default(false);
            $table->text('notas')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['tipo_documento_id', 'numero_documento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
