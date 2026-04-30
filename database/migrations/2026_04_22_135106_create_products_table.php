<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // الربط مع جدول التصنيفات (علاقة 1 إلى متعدد)
            
            
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('slug')->unique();
            
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
// أو لو مكتوب بطريقة تانية، المهم تزود ->nullable()
            $table->decimal('price', 10, 2); // السعر
            $table->integer('stock')->default(0); // المخزون
            $table->string('image')->nullable(); // صورة المنتج الأساسية
            
            $table->boolean('is_active')->default(true); // حالة المنتج (متاح/غير متاح)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};