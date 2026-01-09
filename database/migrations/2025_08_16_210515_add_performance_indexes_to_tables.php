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
        // Add indexes to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('project_date');
            $table->index('slug');
        });

        // Add indexes to team_members table
        Schema::table('team_members', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('slug');
        });

        // Add indexes to services table
        Schema::table('services', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('slug');
        });

        // Add indexes to portfolios table
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index('created_at');
        });

        // Add indexes to contact_messages table
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['project_date']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes from team_members table
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes from services table
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes from portfolios table
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        // Remove indexes from contact_messages table
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
};
