<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = ['company_name', 'company_type', 'manager', 'email', 'address_id', 'user_id','professional_bio','certificates','education'];


    public static function boot()
    {
        parent::boot();


    }

    // Ajoutez une méthode pour rendre le slug unique
    protected function makeUniqueSlug($slug)
    {
        $counter = 2;
        $newSlug = $slug;

        while (static::where('slug', $newSlug)->exists()) {
            $newSlug = $slug . '-' . $counter++;
        }

        return $newSlug;
      }


    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class, 'company_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function companyAddress()
    {
        return $this->belongsTo(CompanyAddress::class, 'address_id');
    }



    // Ajoutez une règle de validation unique pour le champ 'name'
    public static function rules($id = null)
    {
        return [
          'company_name' => 'required|string|max:255|unique:companies,company_name,' . $id,
          'company_type' => 'required|string|max:255',
          'manager' => 'required|string|max:255',
          'email' => 'string|max:255',
          'city_id' => 'string|max:255|unique:companies,city_id,' . $id,
          'dependency_id' => 'string|max:255|unique:companies,dependency_id,' . $id,
        ];
    }


    protected static function booted()
    {
        parent::booted();

        static::created(function ($company) {
          $type= $company-> company_type;

          if (!Role::where('name', $type)->exists()) {
            Role::create([
                'name' => $type,
                'guard_name' => 'web',
                'profile_name' => 'medical company',
            ]);
        }
    });
    }




}

    //protected static function newFactory()
    //{
       // return \Modules\Users\Database\factories\CompanyFactory::new();
    //}

