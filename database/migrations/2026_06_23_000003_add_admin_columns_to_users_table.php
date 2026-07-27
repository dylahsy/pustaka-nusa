<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->after('email');
            $table->string('role')->default('Admin')->after('no_hp');
            $table->string('status')->default('Aktif')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'role', 'status']);
        });
    }
};
