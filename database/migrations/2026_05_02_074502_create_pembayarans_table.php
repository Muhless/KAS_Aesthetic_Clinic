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
     Schema::create('pembayarans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pelayanan_id')->constrained('pelayanans')->onDelete('cascade');
    $table->decimal('total_harga', 12, 2)->default(0);
    $table->enum('metode_bayar', ['cash', 'transfer', 'kartu'])->nullable();
    $table->enum('status', ['belum_bayar', 'lunas'])->default('belum_bayar');
    $table->timestamp('dibayar_pada')->nullable();
    $table->text('catatan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
