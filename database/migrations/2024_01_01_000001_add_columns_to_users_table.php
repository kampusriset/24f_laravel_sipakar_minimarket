<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan kolom role & google_id pada tabel users bawaan Laravel.
 * Role menentukan hak akses: admin atau kasir.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->enum('role', ['admin', 'kasir'])->default('kasir');
});
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'avatar',
                'role'
            ]);
        });
    }
};
