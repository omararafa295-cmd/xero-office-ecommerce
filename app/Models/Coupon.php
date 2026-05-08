<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'usage_limit', 'used_count', 'expires_at'
    ];

    public function isValid()
    {
        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        return true;
    }
}
