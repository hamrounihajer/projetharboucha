<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Database\factories\MedicalTypeFactory;
use Illuminate\Support\Str;
class MedicalType extends Model
{
    use HasFactory;

    protected $table='medical_types';
    protected $fillable = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();

        // Assurez-vous que le slug est unique lors de la création et de la mise à jour
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);

            $originalSlug = $model->getOriginal('slug');

            if ($model->slug !== $originalSlug) {
                // Le slug a changé, ajustez-le pour le rendre unique
                $model->slug = $model->makeUniqueSlug($model->slug);
            }
        });
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
        return $this->hasMany(ServiceCategory::class, 'medical_type_id');
    }



    // Ajoutez une règle de validation unique pour le champ 'name'
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255|unique:medical_types,name,' . $id,
        ];
    }


    protected static function booted()
    {
        parent::booted();

        static::created(function ($medicalType) {
          Role::create([
              'name' => $medicalType->name,
              'guard_name' => 'web',
              'profile_name' => 'medical type',
          ]);
      });

      static::deleted(function ($medicalType) {
          $role = Role::where('name', $medicalType->name)->first();
          if ($role) {
              $role->delete();
          }
      });
    }




}
