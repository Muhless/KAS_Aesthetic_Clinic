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
       Schema::create('antrian', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
    $table->foreignId('dokter_id')->nullable()->constrained('dokter')->onDelete('set null');
    $table->date('tanggal');
    $table->integer('nomor_antrian');
    $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
