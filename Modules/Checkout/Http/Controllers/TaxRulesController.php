<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\TaxRule;
use Modules\Checkout\Entities\Tax;
use Modules\Location\Entities\Country;

class TaxRulesController extends Controller
{
    /**
     * Display a listing of the tax rules.
     */
    public function index()
    {
        $taxRules = TaxRule::all();
        return view('taxrules.index-tax-rules', compact('taxRules'));
    }

    /**
     * Show the form for creating a new tax rule.
     */
    public function create()
    {
        $taxes = Tax::all();
        $countries = Country::all();
        return view('taxrules.create-tax-rules', compact('taxes', 'countries'));
    }

    /**
     * Store a newly created tax rule in storage.
     */
    public function store(Request $request)
    {
        // Validation with custom error messages (optional)
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'tax_id' => 'required|exists:taxes,id'
        ], [
            'country_id.required' => 'The country field is required.',
            'country_id.exists' => 'The selected country is invalid.',
            'tax_id.required' => 'The tax field is required.',
            'tax_id.exists' => 'The selected tax is invalid.'
        ]);

        try {
            $taxRule = new TaxRule();
            $taxRule->country_id = $validated['country_id'];
            $taxRule->tax_id = $validated['tax_id'];
            $taxRule->save();

            return redirect()->route('taxrules.index')->with('success', 'Tax rule created successfully.');
        } catch (\Exception $e) {
            // Handling exceptions during the save process
            return back()->withErrors('There was an error saving the tax rule: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified tax rule.
     */
    public function edit(TaxRule $taxRule)
    {
        $taxes = Tax::all();
        $countries = Country::all();
        return view('taxrules.edit', compact('taxRule', 'taxes', 'countries'));
    }

    /**
     * Update the specified tax rule in storage.
     */
    public function update(Request $request, TaxRule $taxRule)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'tax_id' => 'required|exists:taxes,id'
        ]);

        $taxRule->update([
            'country_id' => $validated['country_id'],
            'tax_id' => $validated['tax_id']
        ]);

        return redirect()->route('taxrules.index')->with('success', 'Tax rule updated successfully.');
    }

    /**
     * Remove the specified tax rule from storage.
     */
    public function destroy(TaxRule $taxRule)
    {
        $taxRule->delete();
        return redirect()->route('taxrules.index')->with('success', 'Tax rule deleted successfully.');
    }
}
