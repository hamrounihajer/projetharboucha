@extends('layouts/contentNavbarLayout')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Taxes /</span> Edit Tax
</h4>

<div class="container">
    <form action="{{ route('taxes.update', $tax->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $tax->name }}" required>
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Rate</label>
            <input type="number" class="form-control" id="rate" name="rate" value="{{ $tax->rate }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type">
                <option value="percentage" {{ $tax->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="fixed" {{ $tax->type == 'fixed' ? 'selected' : '' }}>Fixed Value</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
