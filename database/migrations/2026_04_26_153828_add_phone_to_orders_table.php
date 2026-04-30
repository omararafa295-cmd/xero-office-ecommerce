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
        Schema::table('orders', function (Blueprint $table) {
            // إضافة عمود الموبايل بعد عمود الـ id (أو أي عمود تحبه)
            $table->string('phone')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
