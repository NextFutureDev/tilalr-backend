<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('roles')) {
            // Add 'name' field if it doesn't exist
            if (!Schema::hasColumn('roles', 'name')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->string('name')->nullable()->after('id');
                });

                // Copy title_en to name for existing records
                DB::table('roles')->whereNull('name')->update([
                    'name' => DB::raw('title_en')
                ]);

                // Make name unique and required
                Schema::table('roles', function (Blueprint $table) {
                    $table->string('name')->change();
                    $table->unique('name');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropUnique(['name']);
                $table->dropColumn('name');
            });
        }
    }
};
