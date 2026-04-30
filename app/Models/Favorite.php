<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    // السطر ده هيمنع لارافيل من إرسال الوقت المتعارض مع الداتا بيز
    public $timestamps = false; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}