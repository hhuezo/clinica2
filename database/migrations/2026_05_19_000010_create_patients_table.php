<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F', 'O'])->default('O');
            $table->foreignId('document_type_id')->constrained();
            $table->string('document_number', 50);
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_minor')->default(false);
            $table->text('notes')->nullable();
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['document_type_id', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
