@extends('layouts/contentNavbarLayout')

@section('title', 'Service Categories')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Service Categories</span></h4>

    <!-- Ajoutez un lien vers la page de création -->
    <a href="{{ route('service-category.createForm') }}" class="btn btn-success mb-3">Add Service Category</a>

    <!-- Affichez la liste des types de services ici -->
    @if($serviceCategories->isEmpty())
        <p>Aucune catégorie de service disponible.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Medical Type</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                    <!-- Ajoutez d'autres colonnes si nécessaire -->
                </tr>
            </thead>
            <tbody>
                @foreach($serviceCategories as $serviceCategory)
                    <tr>
                        <th scope="row">{{ $serviceCategory->id }}</th>
                        <td>{{ $serviceCategory->medicalType->name }}</td>
                        <td>{{ $serviceCategory->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <span  style="width: 20px;" ></span>
                                <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" style="width: 23px; height: 16px;">
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Link to the edit form -->
                                    <a href="{{ route('service-category.edit', $serviceCategory->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i>Edit</a>
                                    <!-- Form for delete with confirmation -->
                                    <form action="{{ route('service-category.destroy', $serviceCategory->id) }}" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this service category?')"><i class="mdi mdi-trash-can-outline me-1"></i>Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
