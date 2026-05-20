<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 30)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->string('proveedor')->nullable()->after('avatar');
            $table->string('proveedor_id')->nullable()->after('proveedor');
            $table->boolean('activo')->default(true)->after('proveedor_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'avatar', 'proveedor', 'proveedor_id', 'activo']);
        });
    }
};
