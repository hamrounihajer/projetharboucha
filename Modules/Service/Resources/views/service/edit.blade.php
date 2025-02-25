
@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Service ')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Edit Service  /</span> {{ $service->name }}</h4>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('service.update', $service->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Service Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Service </button>
            </form>
        </div>
    </div>
@endsection
