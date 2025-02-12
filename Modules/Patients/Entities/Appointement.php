<?php

namespace Modules\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class appointement extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable=[
        'patient_id',
        'medical_team_id',
        'availability_id',
        'date',
        'time',
        'status',
        'phone',
        'description',
        'ordonnance',
        'service_categories_id',
        'services_id',
        'care_type',
        'patients_id',
        'appointment_location',
        'created_at',
        'updated_at',
        
    ];
    public function medicalTeam()
    {
        return $this->belongsTo(MedicalTeam::class);
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }
    public function pations()
    {
        return $this->belongsTo(patient::class);
    }

}
