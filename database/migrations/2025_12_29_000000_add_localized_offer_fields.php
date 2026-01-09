<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            // Add per-language columns for details and lists (guarded)
            if (!Schema::hasColumn('offers', 'duration_en')) {
                $table->string('duration_en')->nullable()->after('description_en');
            }
            if (!Schema::hasColumn('offers', 'duration_ar')) {
                $table->string('duration_ar')->nullable()->after('duration_en');
            }
            if (!Schema::hasColumn('offers', 'group_size_en')) {
                $table->string('group_size_en')->nullable()->after('group_size');
            }
            if (!Schema::hasColumn('offers', 'group_size_ar')) {
                $table->string('group_size_ar')->nullable()->after('group_size_en');
            }
            if (!Schema::hasColumn('offers', 'badge_en')) {
                $table->string('badge_en')->nullable()->after('badge');
            }
            if (!Schema::hasColumn('offers', 'badge_ar')) {
                $table->string('badge_ar')->nullable()->after('badge_en');
            }
            if (!Schema::hasColumn('offers', 'features_en')) {
                $table->json('features_en')->nullable()->after('features');
            }
            if (!Schema::hasColumn('offers', 'features_ar')) {
                $table->json('features_ar')->nullable()->after('features_en');
            }
            if (!Schema::hasColumn('offers', 'highlights_en')) {
                $table->json('highlights_en')->nullable()->after('highlights');
            }
            if (!Schema::hasColumn('offers', 'highlights_ar')) {
                $table->json('highlights_ar')->nullable()->after('highlights_en');
            }
        });

        // Migrate existing values into the new *_en columns where possible
        if (Schema::hasTable('offers')) {
            \App\Models\Offer::all()->each(function ($offer) {
                $changed = false;
                if (!$offer->duration_en && $offer->duration) { $offer->duration_en = $offer->duration; $changed = true; }
                if (!$offer->group_size_en && $offer->group_size) { $offer->group_size_en = $offer->group_size; $changed = true; }
                if (!$offer->badge_en && $offer->badge) { $offer->badge_en = $offer->badge; $changed = true; }
                if (!$offer->features_en && $offer->features) { $offer->features_en = $offer->features; $changed = true; }
                if (!$offer->highlights_en && $offer->highlights) { $offer->highlights_en = $offer->highlights; $changed = true; }
                if ($changed) { $offer->save(); }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn([
                'duration_en','duration_ar','group_size_en','group_size_ar',
                'badge_en','badge_ar','features_en','features_ar','highlights_en','highlights_ar'
            ]);
        });
    }
};
