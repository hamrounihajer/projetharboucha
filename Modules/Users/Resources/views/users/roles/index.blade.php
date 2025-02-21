@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11"> <!-- Adjusted the column width to take the full width -->
            <div class="text-end mb-3" >
                <a href="{{ route('roles.create') }}" class="btn btn-success btn-lg shadow-lg" >Add Role</a>
            </div>
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-purple text-white text-center">
                    <h4 class="py-3 mb-0" style="color:white">Roles Table</h4>
                </div>
                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Guard Name</th>
                                <th>Profile Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->profile_name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>{{ $role->updated_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" class="menu-icon">
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="dropdown-item">
                                                    <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                                </a>
                                                <a href="{{ route('roles.show', $role->id) }}" class="dropdown-item">
                                                    <i class="mdi mdi-eye-outline me-1"></i> Show Permissions
                                                </a>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="post" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this role?')">
                                                        <i class="mdi mdi-trash-can-outline me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
