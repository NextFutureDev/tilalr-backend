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
        // Backfill empty slugs with deterministic values based on id
        \DB::statement("UPDATE island_destinations SET slug = CONCAT('island-', id) WHERE slug IS NULL OR slug = ''");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed - this only backfills data
    }
};
