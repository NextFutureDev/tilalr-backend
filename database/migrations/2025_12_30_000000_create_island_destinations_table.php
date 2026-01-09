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
        if (!Schema::hasTable('island_destinations')) {
            Schema::create('island_destinations', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title_en')->nullable();
                $table->string('title_ar')->nullable();
                $table->text('description_en')->nullable();
                $table->text('description_ar')->nullable();
                $table->json('features')->nullable();
                $table->string('image')->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->decimal('rating', 3, 2)->nullable();
                $table->unsignedBigInteger('city_id')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();

                $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
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
        Schema::dropIfExists('island_destinations');
    }
};
