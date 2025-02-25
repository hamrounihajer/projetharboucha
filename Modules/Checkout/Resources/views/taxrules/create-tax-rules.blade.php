{{-- resources/views/tax-rules/create-tax-rules.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">
    <h1>Create Tax Rule</h1>
    <form action="{{ route('taxrules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select id="country_id" name="country_id" class="form-control">
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tax_id" class="form-label">Tax</label>
            <select id="tax_id" name="tax_id" class="form-control">
                @foreach ($taxes as $tax)
                <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Tax Rule</button>
    </form>
</div>
@endsection
