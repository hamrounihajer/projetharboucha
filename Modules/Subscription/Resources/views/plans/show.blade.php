<!-- resources/views/plans/show.blade.php -->

@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ $plan->name }}</h4>
                    </div>
                    <br>

                    <div class="card-body text-center">
                        <h4 class="card-title">Plan Details</h4>
                        <br>
                        <p class="card-text"><strong>ID:</strong> {{ $plan->id }}</p>
                        <p class="card-text"><strong>Grace Days:</strong> {{ $plan->grace_days }}</p>
                        <p class="card-text"><strong>Price:</strong> {{ number_format($plan->price, 2) }} TND</p>
                        <p class="card-text"><strong>Assigned To:</strong> {{ $plan->role->name ?? 'Role not assigned' }}</p>

                        <h6 class="mt-3">Features:</h6>
                        @if($plan->features->isEmpty())
                            <p>No features assigned.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($plan->features as $feature)
                                    <li class="list-group-item">{{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="card-footer text-muted d-flex justify-content-center">
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-secondary mx-2">Edit</a>
                        <a href="{{ route('plans.index') }}" class="btn btn-secondary mx-2">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
