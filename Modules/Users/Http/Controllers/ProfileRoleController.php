<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProfileRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\ModelHasPermission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\ModelHelper;

class ProfileRoleController extends Controller
{
    public function index()
    {
        Log::info('ProfileRoleController@index called');
        $profileRoles = ProfileRole::all();
        return view('profileroles.index', compact('profileRoles'));
    }

    public function create()
    {
        Log::info('ProfileRoleController@create called');
        $models = ModelHelper::getAllModels();
        $permissions = Permission::all();
        return view('profileroles.create', compact('models', 'permissions'));
    }

    public function store(Request $request)
    {
        Log::info('ProfileRoleController@store called with request: ', $request->all());

        $request->validate([
            'profile_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {


            if ($request->has('permissions')) {
                foreach ($request->permissions as $model => $permissionsArray) {
                    Log::info('Processing permissions for model: ' . $model);

                    // Construct the full model type name
                    $modelType = 'App\\Models\\' . $model;

                    // Fetch model_id and model_type from the model_has_permissions table
                    $modelData = DB::table('model_has_permissions')
                        ->where('model_type', $modelType)
                        ->select('model_id', 'model_type')
                        ->first();

                    if ($modelData) {
                        $profileRole = ProfileRole::create([
                            'profile_name' => $request->profile_name,
                            'model_id' => $modelData->model_id,
                            'model_type' => $modelData->model_type,
                            'can_create' => in_array('create', $permissionsArray) ? 1 : 0,
                            'can_view' => in_array('view', $permissionsArray) ? 1 : 0,
                            'can_update' => in_array('update', $permissionsArray) ? 1 : 0,
                            'can_delete' => in_array('delete', $permissionsArray) ? 1 : 0,
                        ]);
                        Log::info('Profile role created: ', $profileRole->toArray());
                    } else {
                        Log::error('Model data not found for model: ' . $modelType);
                    }
                }
            }
            DB::commit();
            Log::info('Profile roles created successfully');
            return redirect()->route('profileroles.index')->with('success', 'Profile role created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating profile role: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the profile role.']);
        }
    }

   public function edit($id)
{
    $profileRole = ProfileRole::with('modelHasPermissions')->findOrFail($id);
    $models = ModelHelper::getAllModels();
    $permissions = ['create', 'view', 'update', 'delete'];

    return view('profileroles.edit', compact('profileRole', 'models', 'permissions'));
}

public function update(Request $request, ProfileRole $profileRole)
{
    Log::info('ProfileRoleController@update called with request: ', $request->all());

    $request->validate([
        'profile_name' => 'required|string',
        'permissions' => 'nullable|array',
    ]);

    DB::beginTransaction();

    try {
        // Update the profile name
        $profileRole->profile_name = $request->input('profile_name');
        $profileRole->save();


            $permissionsArray = $request->input('permissions', []);
            $profileRole->can_create = in_array('create', $permissionsArray) ? 1 : 0;
            $profileRole->can_view = in_array('view', $permissionsArray) ? 1 : 0;
            $profileRole->can_update = in_array('update', $permissionsArray) ? 1 : 0;
            $profileRole->can_delete = in_array('delete', $permissionsArray) ? 1 : 0;
            $profileRole->save();

            // Check if all permissions are 0 and delete the profile role if true
            if (
              $profileRole->can_create == 0 &&
                $profileRole->can_view == 0 &&
                $profileRole->can_update == 0 &&
                $profileRole->can_delete == 0
            ) {
                $profileRole->delete();
            }


        DB::commit();

        Log::info('Profile role updated successfully');
        return redirect()->route('profileroles.index')->with('success', 'Profile role updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating profile role: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'An error occurred while updating the profile role: ' . $e->getMessage()]);
    }
}


    public function destroy(ProfileRole $profileRole)
    {
        Log::info('ProfileRoleController@destroy called with profileRole: ', $profileRole->toArray());

        $profileRole->delete();

        Log::info('Profile role deleted successfully');

        return redirect()->route('profileroles.index')->with('success', 'Profile role deleted successfully.');
    }
}
