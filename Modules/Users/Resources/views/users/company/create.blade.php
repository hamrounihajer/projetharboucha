@extends('layouts/contentNavbarLayout')

@section('title', 'Ajouter une compagnie')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add new company</span></h4>

    <!-- Formulaire d'ajout -->
    <form action="{{ route('company.store') }}" method="post">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Company Name Field -->
        <div class="mb-3">
            <label for="company_name" class="form-label"><i class="bi bi-building"></i> Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" required style="width: 700px;">
        </div>

        <!-- Company Type Field -->
        <div class="mb-3">
            <label for="company_type" class="form-label"><i class="bi bi-briefcase"></i> Company Type</label>
            <input type="text" class="form-control" id="company_type" name="company_type" placeholder="Enter company type" required style="width: 700px;">
        </div>

        <!-- Manager Field -->
        <div class="mb-3">
            <label for="manager" class="form-label"><i class="bi bi-person"></i> Manager</label>
            <input type="text" class="form-control" id="manager" name="manager" placeholder="Enter manager name" required style="width: 700px;">
        </div>

        <!-- Additional Fields (if necessary) -->

        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add</button>
    </form>
@endsection
