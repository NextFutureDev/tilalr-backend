<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Disable foreign key constraints temporarily
        Schema::disableForeignKeyConstraints();

        // Add allowed_modules to roles table
        if (Schema::hasTable('roles') && !Schema::hasColumn('roles', 'allowed_modules')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->json('allowed_modules')->default('[]')->after('sort_order')->comment('List of modules this role can access');
            });
        }

        // Drop permission-related junction tables
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');

        // Drop permissions and related tables
        Schema::dropIfExists('permissions');

        // Drop unnecessary models
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('contact_infos');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('about_sections');

        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // This is a destructive migration - rollback will not recreate tables
        // You would need to re-run your original migrations if needed
    }
};
