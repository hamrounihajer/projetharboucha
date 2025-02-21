@extends('layouts/contentNavbarLayout')
<!-- /Account -->
@section('page-script')
<!-- Inclure le fichier CSS de Bootstrap Datepicker -->
<link rel="stylesheet" href="assets/css/datepicker.css">

<!-- Inclure les fichiers JavaScript requis -->
<script src="assets/js/jquery.timepicker.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/datepicker.js"></script>

<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function addDeleteButton(element) {
        const deleteBtn = document.createElement('span');
        deleteBtn.innerHTML = '<span class="mdi mdi-delete-empty"></span>';
        deleteBtn.classList.add('delete-btn');
        deleteBtn.classList.add('text-danger');
        deleteBtn.style.cursor = 'pointer';
        deleteBtn.onclick = function () {
            element.parentNode.removeChild(element);
        };
        element.appendChild(deleteBtn);
    }

    document.querySelector('.add-service').addEventListener('click', function () {
        const serviceCont = document.querySelector('.service-cont');
        const clone = serviceCont.cloneNode(true);
        addDeleteButton(clone);
        serviceCont.parentNode.appendChild(clone);
    });

    document.querySelector('.add-sub-service').addEventListener('click', function () {
        const subServiceCont = document.querySelector('.sub-service-cont');
        const clone = subServiceCont.cloneNode(true);
        addDeleteButton(clone);
        subServiceCont.parentNode.appendChild(clone);
    });

    document.querySelector('.add-education').addEventListener('click', function () {
        const educationCont = document.querySelector('.education-cont');
        const clone = educationCont.cloneNode(true);
        addDeleteButton(clone);
        educationCont.parentNode.appendChild(clone);
    });

    document.querySelector('.add-award').addEventListener('click', function () {
        const awardsCont = document.querySelector('.awards-cont');
        const clone = awardsCont.cloneNode(true);
        addDeleteButton(clone);
        awardsCont.parentNode.appendChild(clone);
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser le sélecteur de date
        $('.datePicker').datepicker({
            format: '2002-06-25',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#medical_type_id').change(function(){
            var medicalTypeId = $(this).val();
            $.ajax({
                url: '/get-services-by-medical-type/' + medicalTypeId,
                type: 'GET',
                success: function(data){
                    $('#service_category_id').empty();
                    $('#service_category_id').append($('<option>', {
                        value: '',
                        text: 'Select Service Category'
                    }));
                    $.each(data, function(key, value){
                        $('#service_category_id').append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                }
            });
        });
    });
</script>
@endsection
@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Add Informations /</span> Account
</h4>
<form method="post" action="{{ route('medical-team.store') }}">
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
    <div class="card">
                <h5 class="card-header fw-normal">Education And Certificate</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Add Education')}}</label>
                                <div class="education-info">
                                    <div class="row form-row education-cont">
                                        <div class="col-12 col-md-10 col-lg-11">
                                            <div class="row form-row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Degree')}}</label>
                                                        <input type="text"  required name="degree[]" value="bca" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('College/Institute')}}</label>
                                                        <input type="text" required name="college[]" value="saurastra university" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Year of Completion')}}</label>
                                                        <input type="text" maxlength="4" pattern="^[0-9]{4}$"  required name="year[]" value="2022" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i>{{__('Add More')}}</a>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="awards-info">
                                        <div class="row form-row awards-cont">
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label>{{__('certificate')}}</label>
                                                    <input type="text"  required name="certificate[]" value="bca" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label>{{__('Year')}}</label>
                                                    <input type="text" required  name="certificate_year[]" maxlength="4" value="2022" pattern="^[0-9]{4}$" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> {{__('Add More')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>
    <div class="card">
                      <h5 class="card-header fw-normal">Other Information</h5>
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="standard_rate" name="standard_rate" placeholder="Standard Rate">
                                    <label for="standard_rate">Standard Rate</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Experience (in years)')}}</label>
                                <input type="number" min="1" name="experience" value="{{ old('experience') }}"  class="form-control @error('experience') is-invalid @enderror">
                                @error('number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Appointment fees')}}</label>
                                <input type="number" min="1" name="appointment_fees" value="{{ old('appointment_fees') }}"  class="form-control @error('appointment_fees') is-invalid @enderror">
                                @error('appointment_fees')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-6 form-group">
                                    <label class="col-form-label">{{__('Start Time')}}</label>
                                    <input class="form-control timepicker @error('start_time') is-invalid @enderror"  name="start_time" value="{{old('start_time')}}" type="time">
                                    @error('start_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="col-form-label">{{__('End Time')}}</label>
                                    <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time"  value="{{old('end_time')}}" type="time">
                                    @error('end_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-right p-2">
                          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
    </div>
</form>
