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
        // Add blocked_dates column to trips table if it doesn't exist
        if (!Schema::hasColumn('trips', 'blocked_dates')) {
            Schema::table('trips', function (Blueprint $table) {
                // JSON array of dates that are blocked/unavailable for booking
                // Format: ["2026-01-20", "2026-01-21", "2026-02-14"]
                $table->json('blocked_dates')->nullable()->after('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('trips', 'blocked_dates')) {
            Schema::table('trips', function (Blueprint $table) {
                $table->dropColumn('blocked_dates');
            });
        }
    }
};
