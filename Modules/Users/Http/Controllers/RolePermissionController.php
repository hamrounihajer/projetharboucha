<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        // Fetch all model names dynamically
        $models = collect(Schema::getAllTables())->map(function ($table) {
            return array_values((array) $table)[0];
        });

        return view('role_permissions.index', compact('roles', 'permissions', 'models'));
    }

    public function store(Request $request)
    {
        $role = Role::find($request->role_id);

        // Handle the permissions assignment
        foreach ($request->models as $modelName => $permissions) {
            $modelClass = 'App\\Models\\' . ucfirst($modelName);

            if (class_exists($modelClass)) {
                $modelInstance = new $modelClass;

                // Sync model permissions
                foreach ($permissions as $permission) {
                    $permissionModel = Permission::firstOrCreate(['name' => $permission]);
                    $modelInstance->permissions()->syncWithoutDetaching($permissionModel->id);
                }
            }
        }

        // Sync role permissions
        $role->permissions()->sync(array_flatten(array_values($request->models)));

        return back()->with('success', 'Permissions updated successfully.');
    }
}


