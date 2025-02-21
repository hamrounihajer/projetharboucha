<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProfileRole extends Model
{
    protected $table = 'profile_role';
    protected $primaryKey = 'profile_id';
    public $incrementing = true; // Ensure auto-incrementing
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [

        'profile_name',
        'model_id',
        'model_type',
        'can_create',
        'can_view',
        'can_update',
        'can_delete',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the model that this profile role is related to.
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(ModelHasPermission::class, 'model_id');
    }
    public function modelHasPermissions()
    {
        return $this->hasMany(ModelHasPermission::class, 'model_id');
    }

}

    //protected static function newFactory()
    //{
        //return \Modules\Users\Database\factories\ProfileRoleFactory::new();
    //}

