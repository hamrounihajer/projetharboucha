<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalTeam extends Model
{
    use HasFactory;

    protected $table = 'medical_team';

    protected $fillable = [
        'user_id',
        'medical_type_id',
        'medical_address_id',
        'medical_service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medicalType()
    {
        return $this->belongsTo(MedicalType::class, 'medical_type_id');
    }


    public function medicalAddress()
    {
        return $this->belongsTo(MedicalAddress::class, 'medical_address_id');
    }

    public function medicalService()
    {
        return $this->belongsTo(MedicalService::class, 'medical_service_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
  
        public function serviceCategories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'chosen_services', 'medical_team_id', 'service_category_id');
    }

    public function generateTimeSlots()
    {
      if (empty($this->start_time) || empty($this->end_time)) {
        return []; // Retourne un tableau vide si les heures de début ou de fin ne sont pas définies
    }
        $slots = [];
        $startTime = Carbon::createFromFormat('H:i:s', $this->start_time);
        $endTime = Carbon::createFromFormat('H:i:s', $this->end_time);

        while ($startTime->lessThan($endTime)) {
            $endSlotTime = (clone $startTime)->addMinutes($this->appointment_duration);
            if ($endSlotTime->greaterThan($endTime)) {
                break; // Prevents slot from ending after work hours
            }
            $slots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $endSlotTime->format('H:i')
            ];
            $startTime = $endSlotTime->addMinutes($this->break_duration);
        }

        return $slots;
    }
    public function getTimeSlots($id)
{
    $medicalTeam = MedicalTeam::findOrFail($id);
    $timeSlots = $medicalTeam->generateTimeSlots(); // Utilisez la méthode du modèle pour récupérer les créneaux horaires
    return response()->json($timeSlots);
}
public function availabilities()
{
    return $this->hasMany(Availability::class);
}

public function appointments()
{
    return $this->hasMany(Appointment::class);
}
public function availabilitySetting()
{
    return $this->hasOne(AvailabilitySetting::class);
}


}

   // protected static function newFactory()
    //{
        //return \Modules\Users\Database\factories\MedicalTeamFactory::new();
    //}

