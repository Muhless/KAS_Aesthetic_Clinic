<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->dropForeign(['pasien_id']);
        $table->foreign('pasien_id')
              ->references('id')
              ->on('pasiens')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->dropForeign(['pasien_id']);
        $table->foreign('pasien_id')
              ->references('id')
              ->on('pasiens');
    });
}
};
