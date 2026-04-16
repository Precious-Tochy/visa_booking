<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->date('dob')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('departure_city');
            $table->string('destination_city');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->string('trip_type');
            $table->integer('passengers');
            $table->string('class');
            $table->string('airline')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};
