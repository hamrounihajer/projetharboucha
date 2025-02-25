<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Tax;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = Tax::all();
        return view('taxes.index-taxes', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('taxes.create-taxes');
    }
    public function taxManagement()
    {
        return view('taxes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'type' => 'required|in:percentage,fixed'
        ]);

        $tax = new Tax();
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->type = $request->type;
        $tax->save();

        return redirect()->route('taxes.index')->with('success', 'Tax added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        return view('taxes.edit-taxes', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'type' => 'required|in:percentage,fixed'
        ]);

        $tax = Tax::findOrFail($id);
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->type = $request->type;
        $tax->save();

        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->route('taxes.index')->with('success', 'Tax deleted successfully.');
    }
}
