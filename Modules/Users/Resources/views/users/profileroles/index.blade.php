@extends('layouts/contentNavbarLayout')

@section('title', 'Profile Roles')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="text-end mb-3">
                <a href="{{ route('profileroles.create') }}" class="btn btn-success btn-lg shadow-lg" >Add Profile Role</a>
            </div>
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-purple text-white text-center">
                    <h4 class="py-3 mb-0" style="color:white">Profile Role Table</h4>
                </div>
                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Profile Role ID</th>
                                <th>Profile Role Name</th>
                                <th>Model ID</th>
                                <th>Model Type</th>
                                <th>Can Create</th>
                                <th>Can View</th>
                                <th>Can Update</th>
                                <th>Can Delete</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profileRoles as $profileRole)
                                <tr>
                                    <td>{{ $profileRole->profile_id }}</td>
                                    <td>{{ $profileRole->profile_name }}</td>
                                    <td>{{ $profileRole->model_id }}</td>
                                    <td>{{ $profileRole->model_type }}</td>
                                    <td>
                                        @if($profileRole->can_create)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($profileRole->can_view)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($profileRole->can_update)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($profileRole->can_delete)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" class="menu-icon">
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('profileroles.edit', $profileRole->profile_id) }}" class="dropdown-item">
                                                    <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('profileroles.destroy', $profileRole->profile_id) }}" method="post" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this profile role?')">
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
