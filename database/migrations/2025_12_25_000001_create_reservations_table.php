<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('trip_type')->nullable(); // school, corporate, family, private
            $table->string('trip_slug')->nullable();
            $table->string('trip_title')->nullable();
            $table->date('preferred_date')->nullable();
            $table->integer('guests')->default(1);
            $table->text('notes')->nullable();
            $table->json('details')->nullable(); // Additional details as JSON
            $table->enum('status', ['pending', 'contacted', 'confirmed', 'converted', 'cancelled'])->default('pending');
            $table->boolean('admin_contacted')->default(false);
            $table->timestamp('contacted_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('converted_booking_id')->nullable(); // If converted to booking
            $table->timestamps();

            $table->index('email');
            $table->index('status');
            $table->index('trip_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
