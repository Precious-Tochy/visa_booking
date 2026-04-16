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
        Schema::create('car_bookings', function (Blueprint $table) {

$table->id();

$table->foreignId('car_id')->constrained()->cascadeOnDelete();

$table->string('name');
$table->string('email');
$table->string('phone');

$table->string('pickup_location');

$table->date('pickup_date');
$table->date('return_date');

$table->boolean('with_driver')->default(false);

$table->decimal('total_price',10,2);

$table->string('status')->default('pending');

$table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_bookings');
    }
};
