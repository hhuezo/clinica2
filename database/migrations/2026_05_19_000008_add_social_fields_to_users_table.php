<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->string('provider')->nullable()->after('avatar');
            $table->string('provider_id')->nullable()->after('provider');
            $table->boolean('is_active')->default(true)->after('provider_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'provider', 'provider_id', 'is_active']);
        });
    }
};
