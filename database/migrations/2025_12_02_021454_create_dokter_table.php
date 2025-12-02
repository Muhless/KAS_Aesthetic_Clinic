<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('nama');
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->string('str')->nullable();
            $table->string('sip')->nullable();
            $table->string('spesialis')->nullable();
            $table->string('jadwal_praktik')->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokter');
    }
};
