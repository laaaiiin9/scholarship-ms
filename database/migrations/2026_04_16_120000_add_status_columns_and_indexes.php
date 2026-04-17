<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('renewals', function (Blueprint $table) {
            $table->string('status')->default('SUBMITTED')->after('user_id');
            $table->unique(['application_id', 'renewal_period_id'], 'renewals_application_period_unique');
        });

        Schema::table('disbursements', function (Blueprint $table) {
            $table->string('status')->default('PENDING')->after('amount');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->unique(['user_id', 'scholarship_id', 'application_period_id'], 'applications_user_scholarship_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropUnique('applications_user_scholarship_period_unique');
        });

        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('renewals', function (Blueprint $table) {
            $table->dropUnique('renewals_application_period_unique');
            $table->dropColumn('status');
        });
    }
};
