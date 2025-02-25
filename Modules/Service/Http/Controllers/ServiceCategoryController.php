<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Service\Entities\MedicalType;
use Modules\Service\Entities\ServiceCategory;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $serviceCategories = ServiceCategory::all();
        return view('service-category.service-category', compact('serviceCategories'));
    }

    public function createForm()
    {
        $medicalTypes = MedicalType::all();
        return view('service-category.createService', compact('medicalTypes'));
    }

    public function store(Request $request)
    {
          $request->validate([
            'medical_type_id' => 'required|exists:medical_types,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories', 'name')->where('medical_type_id', $request->input('medical_type_id'))
            ],
        ]);
        ServiceCategory::create([
            'medical_type_id' => $request->input('medical_type_id'),
            'name' => $request->input('name'),
        ]);

        return redirect()->route('service-category.service-category')->with('success', 'Service Category ajouté avec succès.');
    }

    public function show($id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $serviceTypes = $serviceCategory->serviceTypes;

        return view('service-category.show', compact('serviceCategory', 'serviceTypes'));
    }

    public function edit($id)
    {
      // Logique pour récupérer les données du type médical à éditer
      $serviceCategory = ServiceCategory::findOrFail($id);

      // Passez les données à la vue d'édition
      return view('service-category.edit', compact('serviceCategory'));
    }

    public function update(Request $request, $id)
    {
        // Logique de mise à jour ici
        $request->validate([
            'name' => 'required|string|max:255',
            // Autres règles de validation si nécessaire
        ]);

        $serviceCategory = ServiceCategory::find($id);

        if (!$serviceCategory) {
            return redirect()->route('service-category.service-category')->with('error', 'Service Category not found.');
        }

        // Effectuez la mise à jour en fonction des données du formulaire
        $serviceCategory->update([
            'name' => $request->input('name'),
            // Autres champs à mettre à jour
        ]);

        // Redirigez vers la liste des types médicaux après la mise à jour
        return redirect()->route('service-category.service-category')->with('success', 'Service Category mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $serviceCategory->delete();

        return redirect()->route('service-category.service-category')->with('success', 'Service Category supprimé avec succès.');
    }
}
