<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('pelayanans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
    $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('set null');
    $table->foreignId('reservasi_id')->nullable()->constrained('reservasis')->onDelete('set null');
    $table->date('tanggal');
    $table->integer('nomor_antrian');
    $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
    $table->text('keluhan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
