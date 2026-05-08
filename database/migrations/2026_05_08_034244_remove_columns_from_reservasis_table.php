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
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->dropColumn(['treatment_id', 'waktu', 'keluhan', 'cancel_reason', 'cancelled_by']);
    });
}
}

public function down()
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->foreignId('treatment_id')->nullable();
        $table->time('waktu')->nullable();
        $table->text('keluhan')->nullable();
        $table->text('cancel_reason')->nullable();
        $table->string('cancelled_by')->nullable();
    });
}


};
