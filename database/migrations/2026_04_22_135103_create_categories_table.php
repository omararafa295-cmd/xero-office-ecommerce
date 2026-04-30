<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // الاسم بالعربي
            $table->string('name_en'); // الاسم بالإنجليزي
            $table->string('slug')->unique(); // الرابط النظيف (مثل: laser-printers)
            $table->string('image')->nullable(); // صورة التصنيف
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};