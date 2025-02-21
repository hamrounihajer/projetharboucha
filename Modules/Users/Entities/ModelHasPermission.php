<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
    use HasFactory;
    protected $table = 'model_has_permissions';
    protected $fillable = [
        'model_id',
        'model_type',
        'can_create',
        'can_view',
        'can_update',
        'can_delete',
    ];
    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\ModelHasPermissionFactory::new();
    }
}
