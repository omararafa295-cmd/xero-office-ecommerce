<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('wallet_number');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->timestamp('finalized_at')->nullable()->after('paid_at');
            $table->string('paymob_intention_id')->nullable()->after('payment_reference');
            $table->string('paymob_transaction_id')->nullable()->after('paymob_intention_id');
            $table->text('paymob_client_secret')->nullable()->after('paymob_transaction_id');
            $table->text('paymob_checkout_url')->nullable()->after('paymob_client_secret');
            $table->longText('payment_payload')->nullable()->after('paymob_checkout_url');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_reference',
                'paid_at',
                'finalized_at',
                'paymob_intention_id',
                'paymob_transaction_id',
                'paymob_client_secret',
                'paymob_checkout_url',
                'payment_payload',
            ]);
        });
    }
};
