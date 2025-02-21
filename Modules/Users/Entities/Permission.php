<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name'];

    protected $attributes = [
        'guard_name' => 'web',
    ];

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    public function models(): \Illuminate\Database\Eloquent\Relations\MorphedByMany
    {
        return $this->morphedByMany(Model::class, 'model', 'model_has_permissions', 'permission_id', 'model_id');
    }
}
    
    //protected static function newFactory()
    //{
       // return \Modules\Users\Database\factories\PermissionFactory::new();
    //}

