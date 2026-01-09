<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns to permissions table
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'name')) {
                $table->string('name')->unique()->after('id');
            }
            if (!Schema::hasColumn('permissions', 'display_name')) {
                $table->string('display_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('permissions', 'description')) {
                $table->text('description')->nullable()->after('display_name');
            }
        });

        // Add missing columns and relationships to roles table
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'name')) {
                $table->string('name')->unique()->after('id');
            }
            if (!Schema::hasColumn('roles', 'display_name')) {
                $table->string('display_name')->nullable()->after('name');
            }
        });

        // Create pivot tables if they don't exist
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['user_id', 'role_id']);
            });
        }

        if (!Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['permission_id', 'role_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['name', 'display_name', 'description']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['name', 'display_name']);
        });
    }
};
