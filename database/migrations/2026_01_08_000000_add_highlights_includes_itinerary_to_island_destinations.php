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
        Schema::table('island_destinations', function (Blueprint $table) {
            // Add highlights columns if they don't exist
            if (!Schema::hasColumn('island_destinations', 'highlights_en')) {
                $table->text('highlights_en')->nullable()->after('description_ar');
            }
            if (!Schema::hasColumn('island_destinations', 'highlights_ar')) {
                $table->text('highlights_ar')->nullable()->after('highlights_en');
            }
            
            // Add includes columns if they don't exist
            if (!Schema::hasColumn('island_destinations', 'includes_en')) {
                $table->text('includes_en')->nullable()->after('highlights_ar');
            }
            if (!Schema::hasColumn('island_destinations', 'includes_ar')) {
                $table->text('includes_ar')->nullable()->after('includes_en');
            }
            
            // Add itinerary columns if they don't exist
            if (!Schema::hasColumn('island_destinations', 'itinerary_en')) {
                $table->longText('itinerary_en')->nullable()->after('includes_ar');
            }
            if (!Schema::hasColumn('island_destinations', 'itinerary_ar')) {
                $table->longText('itinerary_ar')->nullable()->after('itinerary_en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('island_destinations', function (Blueprint $table) {
            $table->dropColumn(['highlights_en', 'highlights_ar', 'includes_en', 'includes_ar', 'itinerary_en', 'itinerary_ar']);
        });
    }
};
