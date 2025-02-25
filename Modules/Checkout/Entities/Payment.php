<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payment extends Model
{
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_identifier',
        'amount',
        'card_token',
        'expiration_date',
    ];

    /**
     * Renvoie la commande associée à ce paiement.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_identifier', 'order_identifier');
    }
}
