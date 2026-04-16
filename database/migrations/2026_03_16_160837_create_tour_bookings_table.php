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
    Schema::create('tour_bookings', function (Blueprint $table) {

        $table->id();

        // Passenger Info
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email');
        $table->string('phone');

        // Tour Details
        $table->string('country')->nullable();
        $table->string('package')->nullable();

        $table->date('departure_date')->nullable();
        $table->date('return_date')->nullable();

        $table->integer('travelers')->default(1);

        $table->string('budget')->nullable();
        $table->string('travel_style')->nullable();
        $table->string('hotel')->nullable();

        $table->text('activities')->nullable();
        $table->text('notes')->nullable();

        $table->string('status')->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
    }
};
