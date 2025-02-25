<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id', 'status', 'total_price', 'order_identifier'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class);  // Assuming each order can have multiple tax entries
    }
    protected static function boot()
    {
        parent::boot();

        // Automatically generate a unique identifier for each order
        static::creating(function ($order) {
            do {
                $order->order_identifier = 'OR' . sprintf('%05d', mt_rand(0, 99999));
            } while (self::where('order_identifier', $order->order_identifier)->exists());
        });
    }
}
