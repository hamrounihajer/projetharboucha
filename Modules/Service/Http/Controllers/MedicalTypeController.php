<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Service\Entities\MedicalType;
use Modules\Service\Entities\ServiceCategory;
use Illuminate\Support\Facades\File;

class MedicalTypeController extends Controller
{
    public function index()
    {
        $medicalTypes = MedicalType::all();
        return view('medical-type.medical-type', compact('medicalTypes'));
    }

    public function createForm()
    {
        return view('medical-type.create');
    }

    public function store(Request $request)
    {
        $request->validate(MedicalType::rules());

        // Le code ci-dessous ne sera atteint que si la validation réussit

        $slug = Str::slug($request->input('name'));

        $existingSlug = MedicalType::where('slug', $slug)->first();

        if ($existingSlug) {
            // Le slug existe déjà, ajustez-le pour le rendre unique
            $slug = $this->makeUniqueSlug($slug);

            // Ajoutez une alerte à la session
            return redirect()->route('medical-type.create')->withErrors(['name' => 'Le nom du type médical existe déjà. Un slug unique a été généré.']);
        }

        $medicalType = MedicalType::create([
            'name' => $request->input('name'),
            'slug' => $slug,
        ]);

        $this->updateVerticalMenuJson();

        return redirect()->route('medical-type.index')->with('success', 'Medical Type ajouté avec succès.');
    }

    private function makeUniqueSlug($slug)
    {
        $counter = 1;
        $newSlug = $slug;

        // Ajoutez un compteur numérique jusqu'à ce que le slug soit unique
        while (MedicalType::where('slug', $newSlug)->first()) {
            $newSlug = $slug . '-' . $counter;
            $counter++;
        }

        return $newSlug;
    }

    public function showMedicalTypes()
    {
        $medicalTypes = MedicalType::all();
        return view('layouts.sections.menu._medical_types', ['medicalTypes' => $medicalTypes]);
    }

    public function destroy($id)
    {
        // Vérifiez d'abord si l'enregistrement existe
        $medicalType = MedicalType::find($id);

        if (!$medicalType) {
            // Gérez le cas où l'enregistrement n'est pas trouvé
            return redirect()->route('medical-type.index')->with('error', 'Medical Type not found.');
        }

        // Supprimez les enregistrements liés dans la table service_categories
        $medicalType->serviceCategories()->delete();

        // Ensuite, supprimez l'enregistrement medical_type
        $medicalType->delete();

        // Mettre à jour le menu vertical
        $this->updateVerticalMenuJson();

        return redirect()->route('medical-type.index')->with('success', 'Medical Type deleted successfully.');
    }

    public function editForm($id)
    {
        // Logique pour récupérer les données du type médical à éditer
        $medicalType = MedicalType::findOrFail($id);

        // Passez les données à la vue d'édition
        return view('medical-type.edit', compact('medicalType'));
    }
    public function update(Request $request, $id)
    {
        // Logique de mise à jour ici

        $medicalType = MedicalType::find($id);

        if (!$medicalType) {
            return redirect()->route('medical-type.index')->with('error', 'Medical Type not found.');
        }

        // Effectuez la mise à jour en fonction des données du formulaire
        $medicalType->update([
            'name' => $request->input('name'),
            // Autres champs à mettre à jour
        ]);

        // Redirigez vers la liste des types médicaux après la mise à jour
        return redirect()->route('medical-type.index')->with('success', 'Medical Type updated successfully.');
    }

    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class)->onDelete('cascade');
    }

    private function updateVerticalMenuJson()
    {
        $menuPath = base_path('resources/menu/verticalMenu.json');

        $menuContents = File::get($menuPath);
        $menuData = json_decode($menuContents, true);

        $medicalTypes = MedicalType::all();

        // Créer un tableau pour les types médicaux dynamiques
        $dynamicMedicalTypes = [];

        // Parcourir tous les types médicaux pour les ajouter au tableau dynamique
        foreach ($medicalTypes as $medicalType) {
            $dynamicMedicalTypes[] = [
                'url' => "/medical-team/show/{$medicalType->slug}",
                'name' => $medicalType->name,
                'slug' => "medical-team-{$medicalType->slug}",
            ];
        }

        // Trouver l'index du bouton "Medical Types" dans le tableau du menu
        $medicalTypesIndex = array_search('Medical Types', array_column($menuData['menu'], 'name'));

        if ($medicalTypesIndex !== false) {
            // Si le bouton "Medical Types" existe déjà, mettez à jour son sous-menu
            $menuData['menu'][$medicalTypesIndex]['submenu'] = $dynamicMedicalTypes;
        } else {
            // Si le bouton "Medical Types" n'existe pas, ajoutez-le à la fin du menu
            $menuData['menu'][] = [
                'url' => "/dynamic-medical-type",
                'name' => 'Medical Types',
                'icon' => 'menu-icon tf-icons mdi mdi-medical-bag',
                'slug' => 'dynamic-medical-types',
                'submenu' => $dynamicMedicalTypes
            ];
        }

        // Écrire le fichier JSON mis à jour
        File::put($menuPath, json_encode($menuData, JSON_PRETTY_PRINT));
    }

    // Mettre à jour le menu à chaque action qui modifie le nom du "Medical Team"
    public function updateMedicalTeamName($newName)
    {
        $menuPath = base_path('resources/menu/verticalMenu.json');
        $menuContents = File::get($menuPath);
        $menuData = json_decode($menuContents, true);

        $medicalTeamIndex = array_search('Medical Team', array_column($menuData['menu'], 'name'));
        if ($medicalTeamIndex !== false) {
            $menuData['menu'][$medicalTeamIndex]['name'] = $newName; // Mettre à jour avec le nouveau nom
        }
        // Écrire le fichier JSON mis à jour
        File::put($menuPath, json_encode($menuData, JSON_PRETTY_PRINT));
    }


}
