<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{

    protected $fillable = ['name', 'rate', 'is_percentage','amount', 'order_id'];
    public function calculateFor($amount)
    {
        return $this->type === 'percentage' ? $amount * ($this->rate / 100) : $this->rate;
    }
    public function order()
    {
        return $this->belongsTo(Order::class);  // Make sure this is correct
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}
