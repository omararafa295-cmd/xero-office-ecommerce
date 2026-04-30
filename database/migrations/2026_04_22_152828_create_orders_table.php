<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // بيانات العميل (ممكن نربطها بـ user_id لو مسجل دخول، بس هنخليها تقبل زوار عاديين كمان)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('shipping_address');
            
            $table->decimal('total_amount', 10, 2); // الإجمالي
            $table->string('payment_method')->default('cash_on_delivery'); // طريقة الدفع (الدفع عند الاستلام مبدئياً)
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending'); // حالة الطلب
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};