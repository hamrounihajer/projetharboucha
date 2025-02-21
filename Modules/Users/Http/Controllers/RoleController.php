<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use App\Models\ProfileRole;
use App\Models\MedicalType;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\File;

use App\Models\company;

use Illuminate\Support\Facades\DB;
use App\Helpers\ModelHelper;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
      $profileroles = ProfileRole::select('profile_name')->distinct()->get();
        return view('roles.create', compact('profileroles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string|max:255',
            'profile_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'profile_name' => $request->profile_name,
            ]);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('error', 'Error creating role.');
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $profileroles = Profilerole::distinct()->get(['profile_name']);

        return view('roles.edit', compact('role', 'profileroles'));
    }



    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'guard_name' => 'required|string|max:255',
        'profile_name' => 'required|string|exists:profile_role,profile_name'
    ]);

    // Find the role by ID
    $role = Role::findOrFail($id);

    // Update the role with the new data
    $role->name = $request->input('name');
    $role->guard_name = $request->input('guard_name');
    $role->profile_name = $request->input('profile_name');
    $role->save();

    // Redirect back to the roles index with a success message
    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}

public function destroy($id)
{
    // Find the role by ID
    $role = Role::findOrFail($id);

    // Check the profile name and delete from the respective table
    if ($role->profile_name === 'medical type') {
       $type= MedicalType::where('name', $role->name);
       $type->delete();
       $this->updateVerticalMenuJson();

    } elseif ($role->profile_name === 'company type') {
      $comp= company::where('company_type', $role->name);
      $comp->delete();    }

    // Delete the role
    $role->delete();

    // Redirect back to the roles index with a success message
    return redirect()->route('roles.index')->with('success', 'Role and associated records deleted successfully.');
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
    public function show($id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Get all profile roles associated with the profile_name of the role
        $profileRoles = Profilerole::where('profile_name', $role->profile_name)->get();

        // Pass the role and associated profile roles to the view
        return view('roles.show', compact('role', 'profileRoles'));
    }
}

