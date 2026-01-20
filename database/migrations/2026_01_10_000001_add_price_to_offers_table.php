<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('discount');
            $table->decimal('price_en', 10, 2)->nullable()->after('price');
            $table->decimal('price_ar', 10, 2)->nullable()->after('price_en');
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['price', 'price_en', 'price_ar']);
        });
    }
};
