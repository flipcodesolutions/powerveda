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
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('photo')->nullable(); // File upload path for product image
            $table->integer('stock')->default(0);
            $table->text('detail')->nullable(); // Product description & ingredients
            $table->string('meta_title')->nullable(); // SEO Meta Title
            $table->text('meta_detail')->nullable(); // SEO Meta Description
            $table->string('og_image')->nullable(); // File upload path for OpenGraph social share image
            $table->string('badge')->nullable()->default('NATURAL');
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('discount')->nullable();
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->integer('reviews_count')->default(0);
            $table->timestamps();
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
