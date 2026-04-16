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
    Schema::table('car_bookings', function (Blueprint $table) {
        $table->time('pickup_time')->after('pickup_date');
    });
}

public function down()
{
    Schema::table('car_bookings', function (Blueprint $table) {
        $table->dropColumn('pickup_time');
    });
}
};
