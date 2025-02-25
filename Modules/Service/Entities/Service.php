<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Service\Entities\ServiceCategory;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_category_id', 'name'];
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
   /* public function medicalTeams()
{
    return $this->belongsToMany(MedicalTeam::class, 'chosen_subservices', 'subservice_id', 'medical_team_id')->withTimestamps();
}
*/
}


