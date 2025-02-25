<!-- resources/views/service-category/edit.blade.php -->
@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Service Category')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Edit Service Category /</span> {{ $serviceCategory->name }}</h4>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('service-category.update', $serviceCategory->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Service Category Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $serviceCategory->name }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Service Category</button>
            </form>
        </div>
    </div>
@endsection
