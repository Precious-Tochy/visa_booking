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
        Schema::table('visa_requests', function (Blueprint $table) {

$table->string('progress_stage')->default('Pending');

$table->string('agent')->nullable();

$table->string('passport')->nullable();

$table->string('bank_statement')->nullable();

$table->string('invitation_letter')->nullable();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
