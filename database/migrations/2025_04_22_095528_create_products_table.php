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

            $table->string('banner')->nullable();
            $table->foreignId('product_category_id')->constrained('product_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
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
