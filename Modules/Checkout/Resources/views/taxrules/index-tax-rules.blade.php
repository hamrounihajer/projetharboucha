{{-- resources/views/tax-rules/index-tax-rules.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">
    <h1 class="mb-4">Tax Rules</h1>
    <a href="{{ route('taxrules.create') }}" class="btn btn-primary mb-3">Add Tax Rule</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Country</th>
                <th scope="col">Tax</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taxRules as $rule)
            <tr>
                <th scope="row">{{ $rule->id }}</th>
                <td>{{ $rule->country->name }}</td>
                <td>{{ $rule->tax->name }}</td>
                <td>
                  <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">                                                <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" class="menu-icon">
                                        </i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('taxrules.edit', $rule->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                            <form action="{{ route('taxrules.destroy', $rule->id) }}" method="post" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this medical type?')"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                            </form>
                                        </div>
                  </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<style>
   .bg-gradient-purple {
        background: linear-gradient(135deg, #6f42c1 0%, #4b0082 100%);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        border-radius: 15px 15px 0 0;
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.1);
        pointer-events: none;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
        transition: background-color 0.3s;
    }

    .btn-lg {
        border-radius: 10px;
        padding: 10px 20px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-lg:hover {
        background-color: #5a33a3;
        transform: translateY(-2px);
    }

    .dropdown-menu a {
        display: flex;
        align-items: center;
    }

    .dropdown-menu a i {
        margin-right: 8px;
    }

    .menu-icon {
        width: 23px;
        height: 16px;
    }

    .badge {
        margin-right: 5px;
    }

    .table {
        font-size: 1.1rem; /* Adjust font size for better readability */
    }

    .table th, .table td {
        padding: 1rem; /* Increase padding for a larger table */
    }
</style>
@endsection
