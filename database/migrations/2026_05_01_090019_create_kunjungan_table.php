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
       Schema::create('kunjungan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
    $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
    $table->date('tanggal');
    $table->string('keluhan')->nullable();
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
