@extends('layouts/contentNavbarLayout')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Tax Rules /</span> Edit Tax Rule
</h4>

<div class="container">
    <form action="{{ route('taxrules.update', $taxRule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select class="form-select" id="country_id" name="country_id" required>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $taxRule->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tax_id" class="form-label">Tax</label>
            <select class="form-select" id="tax_id" name="tax_id" required>
                @foreach($taxes as $tax)
                    <option value="{{ $tax->id }}" {{ $taxRule->tax_id == $tax->id ? 'selected' : '' }}>
                        {{ $tax->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
