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
        Schema::table('renewals', function (Blueprint $table) {
            if (!Schema::hasColumn('renewals', 'status')) {
                $table->string('status')->default('SUBMITTED')->after('user_id');
            }
            $table->text('remarks')->nullable()->after('status');
        });

        Schema::table('disbursements', function (Blueprint $table) {
            if (!Schema::hasColumn('disbursements', 'status')) {
                $table->string('status')->default('PENDING')->after('amount');
            }
            $table->date('payout_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn(['payout_date']);
        });

        Schema::table('renewals', function (Blueprint $table) {
            $table->dropColumn(['remarks']);
        });
    }
};
