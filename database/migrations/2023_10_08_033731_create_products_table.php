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
            $table->string('unique_key', 25)->index();
            $table->string('product_title');
            $table->text('product_description')->nullable();
            $table->string('style', 15);
            $table->string('sanmar_mainframe_color', 25);
            $table->string('size', 10);
            $table->string('color_name', 50);
            $table->double('piece_price')
                  ->nullable()
                  ->default(0);
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
