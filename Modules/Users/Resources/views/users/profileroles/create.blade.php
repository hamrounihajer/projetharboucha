@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Profile Role')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add New Profile Role</span></h4>

    <form action="{{ route('profileroles.store') }}" method="post">
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
            <label for="profile_name" class="form-label">Profile Role Name</label>
            <input type="text" class="form-control" id="profile_name" name="profile_name" required>
        </div>

        <div class="mb-3">
            <label for="permissions" class="form-label">Permissions</label>
            <div id="permissions">
                @foreach($models as $model)
                    <div class="model-permissions mb-2">
                        <h5>{{ class_basename($model) }}</h5>
                        @foreach($permissions as $permission)
                            <label>
                                <input type="checkbox" name="permissions[{{ class_basename($model) }}][]" value="{{ $permission->name }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded and DOM fully parsed');
        });

        // Use passive event listeners for better performance
        document.addEventListener('touchstart', function(e) {
            console.log('Touchstart event detected');
        }, { passive: true });

        document.addEventListener('wheel', function(e) {
            console.log('Wheel event detected');
        }, { passive: true });

        // Additional JavaScript can go here
    </script>
@endsection
