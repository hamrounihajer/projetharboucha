@extends('layouts/contentNavbarLayout')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h1 class="h4" style="color:white">Modifier le rôle {{ $profileRole->profile_name }}</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('profileroles.update', $profileRole->profile_id) }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="profile_name" class="form-label">Nom du profile rôle</label>
                            <input type="text" class="form-control" id="profile_name" name="profile_name" value="{{ $profileRole->profile_name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="permissions" class="form-label">Permissions</label>
                            <div id="permissions" class="border rounded p-3">

                                @if (!empty($profileRole->model_type))

                                    @php
                                        $modelName = class_basename(str_replace('App\\Models\\', '', $profileRole->model_type));
                                    @endphp

                                    <div class="model-permissions mb-2">
                                        <h5 class="fw-bold">{{ $modelName }}</h5>
                                        <div class="form-check">
                                            @foreach(['create', 'view', 'update', 'delete'] as $permission)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission }}" id="{{ $permission }}" {{ $profileRole->{"can_$permission"} ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $permission }}">
                                                        {{ ucfirst($permission) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @else
                                    <p class="text-danger">No model type found.</p>
                                @endif

                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
