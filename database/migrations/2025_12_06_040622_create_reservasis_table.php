<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('reservasis')) {
            # code...
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();


            // Relasi
              $table->unsignedBigInteger('user_id')->nullable();
$table->unsignedBigInteger('pasien_id')->nullable();
$table->unsignedBigInteger('dokter_id')->nullable();
$table->unsignedBigInteger('treatment_id')->nullable();

$table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
$table->foreign('pasien_id')->references('id')->on('pasiens')->nullOnDelete();
$table->foreign('dokter_id')->references('id')->on('dokters')->nullOnDelete();
$table->foreign('treatment_id')->references('id')->on('treatments')->nullOnDelete();

            // Data reservasi
            $table->date('tanggal');
            $table->time('waktu')->nullable();
            $table->string('status')->default('tertunda'); // tertunda, diproses, selesai, dibatalkan

            // Tambahan keluhan pasien
            $table->text('keluhan')->nullable();

            // Data pembatalan
            $table->text('cancel_reason')->nullable();
            $table->string('cancelled_by')->nullable(); // admin/pasien/dokter

            $table->timestamps();
        });
        }   
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
