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
        Schema::table('user_profile', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('last_name');
            $table->text('address')->nullable()->after('contact_number');
            $table->date('birth_date')->nullable()->after('address');
            $table->string('gender')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'address', 'birth_date', 'gender']);
        });
    }
};
