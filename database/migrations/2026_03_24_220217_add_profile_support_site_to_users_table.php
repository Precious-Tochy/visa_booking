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
    Schema::table('users', function (Blueprint $table) {
        $table->string('profile_picture')->nullable()->after('password');
        $table->string('support_email')->nullable()->after('profile_picture');
        $table->string('site_name')->nullable()->after('support_email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['profile_picture', 'support_email', 'site_name']);
    });
}
};
