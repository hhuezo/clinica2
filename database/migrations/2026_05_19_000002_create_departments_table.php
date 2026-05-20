<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained('paises')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('codigo', 10)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['pais_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
