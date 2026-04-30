<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'price',
        'old_price',
        'stock',
        'image',
        'category_id',
        'is_active',
    ];

    // علاقة المنتج بالقسم
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews() { return $this->hasMany(Review::class); }
public function averageRating() { return $this->reviews()->avg('rating') ?: 0; }
}