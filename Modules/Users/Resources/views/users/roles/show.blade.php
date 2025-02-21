@extends('layouts/contentNavbarLayout')

@section('title', 'Show Role Details')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-purple text-white text-center">
                    <h4 class="py-3 mb-0" style="color:white">Profile Roles for: {{ $role->profile_name }}</h4>
                </div>
                <div class="card-body p-4">
                    @if($profileRoles->isEmpty())
                        <p class="text-center">No profile roles found for this profile name.</p>
                    @else
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Model ID</th>
                                    <th>Model Type</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profileRoles as $profileRole)
                                    <tr>
                                        <td>{{ $profileRole->model_id }}</td>
                                        <td>{{ class_basename($profileRole->model_type) }}</td>
                                        <td>
                                            @if($profileRole->can_create)
                                                <span class="badge bg-success">Can Create</span>
                                            @endif
                                            @if($profileRole->can_view)
                                                <span class="badge bg-info">Can View</span>
                                            @endif
                                            @if($profileRole->can_update)
                                                <span class="badge bg-warning">Can Update</span>
                                            @endif
                                            @if($profileRole->can_delete)
                                                <span class="badge bg-danger">Can Delete</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="text-center mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to Roles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-purple {
        background: linear-gradient(135deg, #6f42c1 0%, #4b0082 100%);
    }
    .badge {
        margin-right: 5px;
    }
</style>
@endsection
