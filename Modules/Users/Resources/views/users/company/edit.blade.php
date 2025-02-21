@extends('layouts/contentNavbarLayout')

@section('title', 'Edit compagnie')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Edit company /</span> {{ $company->company_name }}</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('company.update', $company->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name:</label>
                    <input type="text" name="company_name" id="company_name" value="{{ $company->company_name }}" required style="width: 300px;" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="company_type" class="form-label">Company Type:</label>
                    <input type="text" name="company_type" id="company_type" value="{{ $company->company_type }}" required style="width: 300px;" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="manager" class="form-label">Manager:</label>
                    <input type="text" name="manager" id="manager" value="{{ $company->manager }}" required style="width: 300px;" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Update Company</button>
            </form>
        </div>
    </div>
@endsection
