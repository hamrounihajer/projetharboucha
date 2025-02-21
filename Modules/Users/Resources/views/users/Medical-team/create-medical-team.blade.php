@extends('layouts/contentNavbarLayout')

@section('page-script')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the date picker
        $('.datePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        // Filter states based on the selected country
        $('#country').change(function () {
            var countryId = $(this).val();
            console.log('Selected Country ID:', countryId); // Debugging line

            fetch('/get-states-by-country/' + countryId)
                .then(response => response.json())
                .then(data => {
                    console.log('Received States:', data); // Debugging line
                    $('#state').empty();
                    $('#state').append('<option value="">Select State</option>');
                    Object.entries(data).forEach(([id, name]) => {
                        $('#state').append(new Option(name, id));
                    });
                })
                .catch(error => {
                    console.error('Fetch Error:', error); // Debugging line
                });
        });

        // Filter dependencies based on the selected state
        $('#state').change(function () {
            var stateId = $(this).val();
            console.log('Selected State ID:', stateId); // Debugging line

            fetch('/get-dependencies-by-state/' + stateId)
                .then(response => response.json())
                .then(data => {
                    console.log('Received Dependencies:', data); // Debugging line
                    $('#dependency').empty();
                    $('#dependency').append('<option value="">Select Dependency</option>');
                    Object.entries(data).forEach(([id, name]) => {
                        $('#dependency').append(new Option(name, id));
                    });
                })
                .catch(error => {
                    console.error('Fetch Error:', error); // Debugging line
                });
        });
    });
</script>

@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Add Medical Team /</span> Account
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h4 class="card-header">Profile Details</h4>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ asset('assets/img/avatars/doctor.jpg') }}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="profile_photo" class="btn btn-primary me-2 mb-3" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" name="profile_photo" />
            </label>
            <button type="button" class="btn btn-outline-danger account-image-reset mb-3">
              <i class="mdi mdi-reload d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
          </div>
        </div>
      </div>
      <div class="card-body pt-2 mt-1">
      <form method="post" action="{{ route('medical-team.store') }}" enctype="multipart/form-data">
        @csrf
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
            @endif
              <div class="row mt-2 gy-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input class="form-control" type="text" id="firstName" name="firstName" autofocus />
                          <label for="firstName">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input class="form-control" type="text" name="lastName" id="lastName" />
                          <label for="lastName">Last Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="medical_type_id" class="select2 form-select" name="medical_type_id">
                                <option value="">Select Medical Type</option>
                                @foreach($medicalTypes as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <label for="medical_type_id">Medical Type</label>
                        </div>
                    </div>
                  <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                      <input class="form-control" type="text" id="email" name="email" placeholder="john.doe@example.com" />
                      <label for="email">E-mail</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="password" id="password" name="password" placeholder="Password" />
                        <label for="password">Password</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-floating form-floating-outline">
                          <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" />
                          <label for="password_confirmation">Confirm Password</label>
                      </div>
                  </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="language" class="select2 form-select" name="language">
                            <option value="">Select Language</option>
                            <option value="en">English</option>
                            <option value="fr">French</option>
                            </select>
                            <label for="language">Language</label>
                        </div>
                    </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                      <select id="gender" class="select2 form-select" name="gender">
                          <option value="male" {{ old('gender') == "male" ? 'selected' : '' }}>{{__('Male')}}</option>
                          <option value="female" {{ old('gender') == "female" ? 'selected' : '' }}>{{__('Female')}}</option>
                          <option value="other" {{ old('gender') == "other" ? 'selected' : '' }}>{{__('Other')}}</option>
                      </select>
                      <label for="gender">Gender</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="202 555 0111" />
                      <label for="phoneNumber">Phone Number</label>
                    </div>
                    <span class="input-group-text">TN (+216)</span>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                      <input class="form-control" type="date" id="dob" name="dob" />
                      <label for="dob">Date of Birth</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select id="country" class="select2 form-select" name="country_id">
                            <option value="">Select Country</option>
                            @foreach($countries as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select id="state" class="select2 form-select" name="state_id">
                            <option value="">Select State</option>
                            @foreach($states as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="state">State</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select id="dependency" class="select2 form-select" name="dependency_id">
                            <option value="">Select Dependency</option>
                            @foreach($dependencies as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="dependency">Dependency</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select id="city" class="select2 form-select" name="city_id">
                            <option value="">Select City</option>
                            @foreach($cities as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="city">City</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select id="currency_id" class="select2 form-select" name="currency_id">
                            <option value="">Select Currency</option>
                            @foreach($currencies as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="currency_id">Currency</label>
                    </div>
                </div>
              </div>
              <div class="text-right p-2">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
              </div>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection
