<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lastname', 'address', 'email', 'gender', 'description',];
    
    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\PatientFactory::new();
    }
}
