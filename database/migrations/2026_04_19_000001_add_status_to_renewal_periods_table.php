<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('renewal_periods', function (Blueprint $table) {
            $table->string('status')->default('DRAFT')->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('renewal_periods', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
