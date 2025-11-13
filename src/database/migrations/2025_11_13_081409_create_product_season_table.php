<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id(); // bigint unsigned, PK
            $table->unsignedBigInteger('product_id'); // FK products(id)
            $table->unsignedBigInteger('season_id'); // FK seasons(id)
            $table->timestamps();

            // 外部キー制約
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_season');
    }
};
