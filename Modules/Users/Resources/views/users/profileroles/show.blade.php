@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Permissions for profile role: {{ $profilerole->name }}</div>

                <div class="card-body">
                    <div>
                        <ul>
                            @foreach($permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
