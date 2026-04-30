<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // علاقة الطلب بالعناصر اللي جواه
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}