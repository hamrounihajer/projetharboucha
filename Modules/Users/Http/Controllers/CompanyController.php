<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Users\HttpServiceCategory;
use Modules\Users\Entities\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('company.company', compact('companies'));
    }

    public function createForm()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate(Company::rules());

        $company = Company::create([
            'company_name' => $request->input('company_name'),
            'company_type' => $request->input('company_type'),
            'manager' => $request->input('manager'),
        ]);

        return redirect()->route('company.index')->with('success', 'Company added successfully.');
    }

    public function showCompanies()
    {
        $companies = Company::all();
        return view('layouts.sections.menu.companies', ['companies' => $companies]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect()->route('company.index')->with('error', 'Company not found.');
        }

        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company deleted successfully.');
    }

    public function editForm($id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect()->route('company.index')->with('error', 'Company not found.');
        }

        $company->update([
            'company_name' => $request->input('company_name'),
            'company_type' => $request->input('company_type'),
            'manager' => $request->input('manager'),
        ]);

        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }
}

