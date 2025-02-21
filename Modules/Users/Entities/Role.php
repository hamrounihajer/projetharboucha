<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'guard_name','profile_name'];

    public function users()
    {
      return $this->hasMany(User::class, 'role_id');

    }


    //protected static function newFactory()
    //{
        //return \Modules\Users\Database\factories\RoleFactory::new();
   // }
}
