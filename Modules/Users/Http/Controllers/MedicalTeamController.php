<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\MedicalTeam;
use App\Models\User;
use App\Models\Role;
use App\Models\Currency;
use App\Models\Country;
use App\Models\State;
use App\Models\Dependency;
use App\Models\City;
use App\Models\MedicalType;
use App\Models\MedicalService;
use App\Models\MedicalAddress;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class MedicalTeamController extends Controller
{
    public function index(Request $request)
    {
        $countryId = $request->input('country_id');

        $medicalTeams = MedicalTeam::all();
        $medicalTypes = MedicalType::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $states = State::where('country_id', $countryId)->pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $currencies = Currency::pluck('name', 'id');
        $dependencies = Dependency::pluck('name', 'id');

        return view('medical-team.create-medical-team', compact('medicalTypes', 'currencies', 'medicalTeams', 'countries', 'states', 'cities', 'dependencies'));
    }

    public function createForm(Request $request)
    {
        $countryId = $request->input('country_id');

        $medicalTeams = MedicalTeam::all();
        $medicalTypes = MedicalType::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $states = State::where('country_id', $countryId)->pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $currencies = Currency::pluck('name', 'id');
        $dependencies = Dependency::pluck('name', 'id');

        return view('medical-team.create-medical-team', compact('medicalTypes', 'currencies', 'medicalTeams', 'countries', 'states', 'cities', 'dependencies'));
    }

    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->pluck('name', 'id');

        return response()->json($states);
    }

    public function getDependenciesByState($stateId)
    {
        $dependencies = Dependency::where('state_id', $stateId)->pluck('name', 'id');
        return response()->json($dependencies);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'medical_type_id' => 'required|exists:medical_types,id',
            'phoneNumber' => 'required|string|max:20|unique:users,Phone',
            'gender' => 'required|string|in:male,female,other',
            'dob' => 'required|date',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'dependency_id' => 'required|exists:dependencies,id',
            'language' => 'required|string|in:en,fr',
            'currency_id' => 'required|exists:currencies,id',
            'password' => 'required|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800'
        ]);
        $medicalTypeName = MedicalType::find($request->medical_type_id)->name;
        $role = Role::where('name', $medicalTypeName)->first();

        // Create a new User record
        $user = new User();
        $user->name = $request->firstName . ' ' . $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phoneNumber;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->role_id = $role->id;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $photoPath;
        }

        $user->save();

        // Create the related MedicalAddress record
        $medicalAddress = new MedicalAddress();
        $medicalAddress->address_complete = $request->address_complete;
        $medicalAddress->dependency_id = $request->dependency_id;
        $medicalAddress->currency_id = $request->currency_id;
        $medicalAddress->country_id = $request->country_id;
        $medicalAddress->state_id = $request->state_id;
        $medicalAddress->city_id = $request->city_id;
        $medicalAddress->save();

        // Create the related MedicalService record
        $medicalService = new MedicalService();
        $medicalService->language = $request->language;
        $medicalService->experience = $request->experience;
        $medicalService->appointment_fees = $request->appointment_fees;
        $medicalService->start_time = $request->start_time;
        $medicalService->end_time = $request->end_time;
        $medicalService->education = $request->education;
        $medicalService->certificates = $request->certificates;
        $medicalService->professional_bio = $request->professional_bio;
        $medicalService->nbre_feedbacks = 0;
        $medicalService->save();

        // Create a new MedicalTeam record with validated data
        $medicalTeam = new MedicalTeam();
        $medicalTeam->user_id = $user->id;
        $medicalTeam->medical_type_id = $request->medical_type_id;
        $medicalTeam->medical_address_id = $medicalAddress->id;
        $medicalTeam->medical_service_id = $medicalService->id;
        $medicalTeam->save();

        // Redirect the user to an appropriate view or route
        return redirect()->route('create-medical-team')->with('success', 'Le formulaire a été enregistré avec succès !');
    }

    public function showFilteredTeam($medicalTypeSlug)
    {
        // Find the medical type by slug
        $medicalType = MedicalType::where('slug', $medicalTypeSlug)->firstOrFail();

        // Retrieve the medical teams filtered by medical type
        $medicalTeam = MedicalTeam::where('medical_type_id', $medicalType->id)->get();

        // Return the view with the data
        return view('medical-team.medical_team', compact('medicalType', 'medicalTeam'));
    }

    public function showTeamDetails($id)
    {
        $medicalTeam = MedicalTeam::with([
            'medicalAddress.country',
            'medicalAddress.state',
            'medicalAddress.dependency',
            'medicalAddress.city'
        ])->findOrFail($id);

        return view('medical-team.team-details', compact('medicalTeam'));
    }


    public function editForm($id)
    {
        $team = MedicalTeam::findOrFail($id);
        return view('medical-team.edit-form', compact('team'));
    }

    public function updateTeamData(Request $request, $id)
{
    // Retrieve the medical team to be updated
    $medicalTeam = MedicalTeam::findOrFail($id);

    // Update the related User record
    $user = User::findOrFail($medicalTeam->user_id);

    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phoneNumber' => 'required|string|max:20|unique:users',

    ]);

    // Update the User record
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phoneNumber; // Update phone number
    $user->save();

    // Retrieve the medical type slug
    $medicalTypeSlug = $medicalTeam->medicalType->slug;

    // Redirect the user with a success message
    return redirect()->route('medical-team.showFiltered', ['medicalTypeSlug' => $medicalTypeSlug])->with('success', 'User information has been updated successfully.');
}


public function destroy($id)
{
    // Variable to hold the slug for redirection
    $medicalTypeSlug = '';

    DB::transaction(function () use ($id, &$medicalTypeSlug) {
        // Find the medical team to delete
        $team = MedicalTeam::findOrFail($id);

        // Retrieve related IDs
        $userId = $team->user_id;
        $medicalAddressId = $team->medical_address_id;
        $medicalServiceId = $team->medical_service_id;

        // Retrieve the medical type slug for redirection
        $medicalTypeSlug = $team->medicalType->slug;

        // Delete the medical team
        $team->delete();

        // Delete the related User, MedicalAddress, and MedicalService records
        User::destroy($userId);
        MedicalAddress::destroy($medicalAddressId);
        MedicalService::destroy($medicalServiceId);
    });

    // Redirect back to the same view with a success message
    return redirect()->route('medical-team.showFiltered', ['medicalTypeSlug' => $medicalTypeSlug])
                     ->with('success', 'L\'équipe médicale a été supprimée avec succès.');
}

}

