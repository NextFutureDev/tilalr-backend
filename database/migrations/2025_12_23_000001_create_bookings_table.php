<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->date('date')->nullable();
            $table->integer('guests')->default(1);
            $table->json('details')->nullable();
            $table->enum('status', ['pending','confirmed','cancelled'])->default('pending');
            $table->enum('payment_status', ['pending','paid','failed'])->default('pending');
            $table->timestamps();

            $table->index('service_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};