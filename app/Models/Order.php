<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'finalized_at' => 'datetime',
        ];
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'card' => __('فيزا / بطاقة بنكية'),
            'wallet' => __('محفظة إلكترونية'),
            default => __('نقداً عند الاستلام'),
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => __('تم الدفع'),
            'failed' => __('فشل الدفع'),
            'cash_on_delivery' => __('الدفع عند الاستلام'),
            default => __('بانتظار الدفع'),
        };
    }

    public function isOnlinePayment(): bool
    {
        return in_array($this->payment_method, ['card', 'wallet'], true);
    }

    public function isPayable(): bool
    {
        return $this->isOnlinePayment() && $this->payment_status !== 'paid';
    }

    // علاقة الطلب بالعناصر اللي جواه
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
