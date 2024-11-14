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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->unique();
            $table->string('product_url')->unique();
            $table->text('description')->nullable();
            $table->longText('product_images');
            $table->foreignUuid('brand_id')->nullable()->constrained()->references('id')->on('brands');
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignUuid('subcategory_id')->nullable()->constrained()->references('id')->on('sub_categories');
            $table->decimal('price', 9, 2)->nullable();
            $table->json('tags')->nullable();
            $table->longText('product_broucher')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
