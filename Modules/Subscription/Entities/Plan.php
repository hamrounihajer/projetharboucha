<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subscription extends Model
{
    protected $fillable = [
        'plan_id', 'started_at', // and other relevant fields
    ];

    public function subscriber()
    {
        return $this->morphTo();
    }

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }
}
