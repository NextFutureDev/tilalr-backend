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
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('role_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->timestamps();

                // Add foreign keys if the referenced tables exist in this project
                if (Schema::hasTable('roles') && Schema::hasTable('users')) {
                    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            if (Schema::hasTable('roles')) {
                $table->dropForeign(['role_id']);
            }
            if (Schema::hasTable('users')) {
                $table->dropForeign(['user_id']);
            }
        });

        Schema::dropIfExists('role_user');
    }
};
