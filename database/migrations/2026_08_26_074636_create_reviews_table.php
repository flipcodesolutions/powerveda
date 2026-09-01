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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author'); // Reviewer / Customer Name
            $table->string('location')->nullable(); // e.g. Mumbai, Delhi
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete(); // Associated Product
            $table->tinyInteger('rating')->default(5); // 1 to 5 stars
            $table->text('comment'); // Review / Testimonial content
            $table->string('photo')->nullable(); // Reviewer avatar / photo file path
            $table->string('status')->default('Approved'); // Approved, Pending, Hidden
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
