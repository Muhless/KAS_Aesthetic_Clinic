<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pasien_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('treatment_id')->nullable()->constrained()->onDelete('set null');

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

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
