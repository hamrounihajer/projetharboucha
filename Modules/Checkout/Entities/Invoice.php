<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_identifier', 'total_price', 'plan_id', 'user_email', 'user_name', 'user_id', 'reference'
    ];

    /**
     * La relation vers le modèle Plan.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * La relation vers le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La relation vers le modèle Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_identifier', 'order_identifier');
    }

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generating a unique reference number for each invoice
        static::creating(function ($invoice) {
            $invoice->reference = 'FR' . sprintf('%05d', mt_rand(10000, 99999));
        });
    }
}
