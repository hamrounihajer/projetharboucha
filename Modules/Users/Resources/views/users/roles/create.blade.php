@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Role')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add New Role</span></h4>

    <form action="{{ route('roles.store') }}" method="post">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="guard_name" class="form-label">Guard Name</label>
            <input type="text" class="form-control" id="guard_name" name="guard_name" required>
        </div>

        <div class="mb-3">
            <label for="profile_name" class="form-label">Profile Name</label>
            <select class="form-control" id="profile_name" name="profile_name" required>
                <option value="">Select Profile</option>
                @foreach($profileroles as $profilerole)
                    <option value="{{ $profilerole->profile_name }}">{{ $profilerole->profile_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection
