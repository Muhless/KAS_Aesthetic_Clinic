<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('pemeriksaan_produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pemeriksaan_id')->constrained('pemeriksaans')->onDelete('cascade');
        $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
        $table->integer('qty')->default(1);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_produk');
    }
};
