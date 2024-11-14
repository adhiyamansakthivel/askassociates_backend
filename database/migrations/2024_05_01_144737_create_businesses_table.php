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
        Schema::create('businesses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('logo')->nullable();
            $table->string('name')->unique();
            $table->string('email');
            $table->string('phone_one');
            $table->string('phone_two')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('gst_number')->nullable();
            $table->text('address')->nullable();
            $table->text('map')->nullable();
            $table->longText('open_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
