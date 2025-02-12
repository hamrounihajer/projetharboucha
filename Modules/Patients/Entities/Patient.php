<?php

namespace Modules\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'lastname', 'address', 'email', 'gender', 'description',
    ];
    public function appointments()
    {
        
        return $this->hasMany(Appointment::class);
    }
}