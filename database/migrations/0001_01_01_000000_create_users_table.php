<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable()->unique();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('role', ['admin', 'dokter', 'terapis', 'kasir'])
                  ->default('admin');

            $table->string('akun')->unique();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
