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
       Schema::create('pembayaran_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
    $table->enum('jenis', ['treatment', 'produk']);
    $table->foreignId('treatment_id')->nullable()->constrained('treatments')->onDelete('set null');
    $table->foreignId('produk_id')->nullable()->constrained('produks')->onDelete('set null');
    $table->integer('qty')->default(1);
    $table->decimal('harga_satuan', 12, 2);
    $table->decimal('subtotal', 12, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_items');
    }
};
