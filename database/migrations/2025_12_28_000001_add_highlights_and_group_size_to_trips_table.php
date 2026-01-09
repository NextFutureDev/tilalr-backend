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
        Schema::table('trips', function (Blueprint $table) {
            if (!Schema::hasColumn('trips', 'group_size')) {
                $table->string('group_size')->nullable()->after('type');
            }

            if (!Schema::hasColumn('trips', 'highlights')) {
                $table->json('highlights')->nullable()->after('images');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            if (Schema::hasColumn('trips', 'group_size')) {
                $table->dropColumn('group_size');
            }
            if (Schema::hasColumn('trips', 'highlights')) {
                $table->dropColumn('highlights');
            }
        });
    }
};