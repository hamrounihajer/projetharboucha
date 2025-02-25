<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionRenewal extends Model
{
    use HasFactory;

    protected $casts = [
        'overdue' => 'boolean',
        'renewal' => 'boolean',
    ];

    protected $fillable = [
        'overdue',
        'renewal',
    ];

    public function subscription()
    {
        return $this->belongsTo(config('soulbscription.models.subscription'));
    }
}
