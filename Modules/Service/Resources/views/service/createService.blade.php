

@extends('layouts/contentNavbarLayout')

@section('title', 'Add Service ')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add Service </span></h4>

    <!-- Affichez l'alerte ici -->
    @if(session('alert'))
        <div class="alert alert-warning">
            {{ session('alert') }}
        </div>
    @endif

    <!-- Formulaire d'ajout de sous-catégorie de service -->
    <form action="{{ route('service.store') }}" method="post">
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
            <label for="service_category_id" class="form-label">Service Category:</label>
            <select class="form-select" id="service_category_id" name="service_category_id" required>
                @foreach($serviceCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Service  Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection
