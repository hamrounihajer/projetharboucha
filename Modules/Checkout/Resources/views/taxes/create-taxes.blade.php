{{-- resources/views/taxes/create-taxes.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Taxes /</span> Add New Tax
</h4>

<div class="container">
    <form action="{{ route('taxes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Rate</label>
            <input type="number" class="form-control" id="rate" name="rate" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type">
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed Value</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
