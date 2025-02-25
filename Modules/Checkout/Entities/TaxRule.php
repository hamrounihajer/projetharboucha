<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRule extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'tax_id'];

    // Relation avec le modèle Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relation avec le modèle Tax
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
