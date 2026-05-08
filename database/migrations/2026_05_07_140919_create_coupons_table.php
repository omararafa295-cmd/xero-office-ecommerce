<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // كود الخصم مثل: SAVE20
        $table->enum('type', ['fixed', 'percent']); // نوع الخصم: ثابت أو نسبة مئوية
        $table->decimal('value', 8, 2); // قيمة الخصم
        $table->integer('usage_limit')->nullable(); // الحد الأقصى للاستخدام
        $table->integer('used_count')->default(0); // تم استخدامه كام مرة
        $table->date('expires_at')->nullable(); // تاريخ الانتهاء
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
