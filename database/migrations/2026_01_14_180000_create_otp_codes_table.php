<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('otp_codes')) {
            Schema::create('otp_codes', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->index();
                $table->string('code'); // hashed
                $table->string('type')->default('login'); // login | register
                $table->integer('attempts')->default(0);
                $table->timestamp('expires_at')->nullable();
                $table->timestamp('used_at')->nullable();
                $table->timestamps();

                $table->index(['phone', 'type']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('otp_codes');
    }
};