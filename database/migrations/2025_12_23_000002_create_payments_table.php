<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('method')->default('dummy');
            $table->enum('status', ['pending','paid','failed'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->index('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};