<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint unsigned, PK
            $table->string('name', 255); // 商品名
            $table->integer('price'); // 商品料金
            $table->string('image', 255); // 商品画像
            $table->text('description'); // 商品説明
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
