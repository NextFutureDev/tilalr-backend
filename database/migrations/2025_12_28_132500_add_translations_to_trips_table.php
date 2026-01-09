<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->json('title_trans')->nullable()->after('title');
            $table->json('description_trans')->nullable()->after('description');
            $table->json('content_trans')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['title_trans', 'description_trans', 'content_trans']);
        });
    }
};
