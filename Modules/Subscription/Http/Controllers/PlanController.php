<?php

namespace Modules\Subscription\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Subscription\Entities\Plan;
use Modules\Users\Entities\Role;
use Modules\Checkout\Entities\Tax;
use Modules\Subscription\Entities\Feature;         
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('role')->get(); // Eager load roles
        $count = $plans->count();
        return view('plans.index', compact('plans', 'count'));
    }

    public function create()
    {
        $features = Feature::all();
        $assignableRoles = Role::where('subscribe', true)->get(); // Fetch roles where subscribe is true
        $taxes = Tax::all(); // Fetch all tax rates

        return view('plans.create', compact('features', 'assignableRoles', 'taxes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'grace_days' => 'required|integer',
            'price_HT' => 'required|numeric',
            'price' => 'required|numeric',
            'periodicity' => 'required',
            'assigned_role' => 'required|exists:roles,id',
            'features' => 'array',
            'feature_values' => 'array',
            'currency' => 'required|string|max:3',
            'status' => 'boolean',
        ]);

        Log::info('Validation passed.');

        // Convert periodicity number to string
        $periodicityMap = [
            '1' => 'Monthly',
            '3' => 'Quarterly',
            '12' => 'Annually'
        ];

        $periodicityString = $periodicityMap[$validatedData['periodicity']] ?? 'Unknown';

        // Create the plan
        $plan = Plan::create([
            'name' => $validatedData['name'],
            'grace_days' => $validatedData['grace_days'],
            'price_HT' => $validatedData['price_HT'],
            'price' => $validatedData['price'],
            'periodicity_type' => $periodicityString,
            'role_id' => $validatedData['assigned_role'],
            'currency' => $validatedData['currency'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Attach features to the plan with values if any
        if (isset($validatedData['features'])) {
            foreach ($validatedData['features'] as $featureId) {
                $value = $validatedData['feature_values'][$featureId] ?? null;
                $timestamps = [
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $plan->features()->attach($featureId, array_merge(['charges' => $value], $timestamps));
            }
        }

        return redirect()->route('plans.index')->with('success', 'Plan added successfully!');
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $features = Feature::all();
        $assignableRoles = Role::where('subscribe', true)->get();
        $taxes = Tax::all(); // Fetch all tax rates

        // Fetch existing feature values
        $featureValues = $plan->features->pluck('pivot.charges', 'id')->toArray();

        return view('plans.edit', compact('plan', 'features', 'assignableRoles', 'featureValues','taxes'));
    }

    public function update(Request $request, Plan $plan)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'grace_days' => 'required|integer',
            'price_HT' => 'required|numeric',
            'price' => 'required|numeric',
            'periodicity' => 'required',
            'assigned_role' => 'required|exists:roles,id',
            'features' => 'array',
            'feature_values' => 'array',
            'currency' => 'required|string|max:3',
            'status' => 'boolean',
        ]);

        // Convert periodicity number to string
        $periodicityMap = [
            '1' => 'Monthly',
            '3' => 'Quarterly',
            '12' => 'Annually'
        ];

        $periodicityString = $periodicityMap[$validatedData['periodicity']] ?? 'Unknown';

        // Update the plan
        $plan->update([
            'name' => $validatedData['name'],
            'grace_days' => $validatedData['grace_days'],
            'price_HT' => $validatedData['price_HT'],
            'price' => $validatedData['price'],
            'periodicity_type' => $periodicityString,
            'role_id' => $validatedData['assigned_role'],
            'currency' => $validatedData['currency'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Synchronize the selected features with values and timestamps
        $features = [];
        if (isset($validatedData['features'])) {
            foreach ($validatedData['features'] as $featureId) {
                $value = $validatedData['feature_values'][$featureId] ?? null;
                $features[$featureId] = array_merge(['charges' => $value], [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $plan->features()->sync($features);

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function show($id)
    {
        $plan = Plan::with(['features', 'role'])->findOrFail($id);
        return view('plans.show', compact('plan'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }

    // Front-end
    public function indexfront()
    {
        $userRoleId = Auth::user()->role_id;
        $plans = Plan::where('role_id', $userRoleId)->get();
        return view('Dashboard.packages', compact('plans'));
    }
}
