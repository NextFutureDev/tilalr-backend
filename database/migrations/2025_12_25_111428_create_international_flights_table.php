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
        Schema::create('international_flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline_en'); // Airline name in English
            $table->string('airline_ar'); // Airline name in Arabic
            $table->string('route_en'); // Route in English
            $table->string('route_ar'); // Route in Arabic
            $table->string('departure_time'); // Departure time (06:00 AM)
            $table->string('arrival_time'); // Arrival time (08:30 AM)
            $table->string('duration'); // Duration (2h 30m)
            $table->string('stops_en'); // Stops description in English
            $table->string('stops_ar'); // Stops description in Arabic
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_flights');
    }
};
