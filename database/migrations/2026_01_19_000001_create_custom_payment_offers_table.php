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
        Schema::create('custom_payment_offers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->string('unique_link')->unique();
            $table->string('payment_status')->default('pending'); // pending, completed, failed, cancelled
            $table->string('moyasar_transaction_id')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // admin who created it
            $table->timestamps();
            $table->index('unique_link');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_payment_offers');
    }
};
