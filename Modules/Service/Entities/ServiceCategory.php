<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['medical_type_id', 'name'];

    public function medicalType()
    {
        return $this->belongsTo(MedicalType::class);
    }/*
    public function medicalTeams()
    {
        return $this->belongsToMany(MedicalTeam::class, 'chosen_services', 'service_category_id', 'medical_team_id')->withTimestamps();

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }*/
    public function services()
{
    return $this->hasMany(Service::class);
}
}