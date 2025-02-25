<!-- resources/views/service-category/createService.blade.php -->

@extends('layouts/contentNavbarLayout')

@section('title', 'Add Service Category')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add Service Category</span></h4>

    <!-- Affichez l'alerte ici -->
    @if(session('alert'))
        <div class="alert alert-warning">
            {{ session('alert') }}
        </div>
    @endif

    <!-- Formulaire d'ajout de catégorie de service -->
    <form action="{{ route('service-category.store') }}" method="post">
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

        <div class="mb-3">
            <label for="medical_type_id" class="form-label">Medical Type</label>
            <select class="form-select" id="medical_type_id" name="medical_type_id" required>
                @foreach($medicalTypes as $medicalType)
                    <option value="{{ $medicalType->id }}">{{ $medicalType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Service Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection
