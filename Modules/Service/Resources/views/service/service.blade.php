<!-- resources/views/service-sub-category/service-sub-category.blade.php -->

@extends('layouts/contentNavbarLayout')

@section('title', 'Services')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Services</span></h4>

    <!-- Ajoutez un lien vers la page de création -->
    <a href="{{ route('service.createForm') }}" class="btn btn-success mb-3">Add Service </a>

    <!-- Affichez la liste des types de services ici -->
    @if($services->isEmpty())
        <p>Aucun service disponible.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Service Category</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <th scope="row">{{ $service->id }}</th>
                        <td>{{ $service->serviceCategory->name }}</td>
                        <td>{{ $service->name }}</td>
                        <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"> <span  style="width: 20px;" ></span>
                            <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" style="width: 23px; height: 16px;"></button>
                            <div class="dropdown-menu">
                            <!-- Link to the edit form -->
                            <a href="{{ route('service.edit', $service->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i>Edit</a>
                            <!-- Form for delete with confirmation -->
                            <form action="{{ route('service.destroy', $service->id) }}" method="post" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this service?')"><i class="mdi mdi-trash-can-outline me-1"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
