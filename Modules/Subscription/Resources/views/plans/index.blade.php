@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Plans</div>

                    <div class="card-body">
                        <a href="{{ route('plans.create') }}" class="btn btn-primary mb-3">Add Plan</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Grace Days</th>
                                    <th>Price HT</th>
                                    <th>Taxed Price</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->id }}</td>
                                        <td>{{ $plan->name }}</td>
                                        <td>{{ $plan->grace_days }}</td>
                                        <td>{{ $plan->price_HT }}</td>
                                        <td>{{ $plan->price }}</td>
                                        <td>{{ $plan->role->name }}</td>
                                        <td>
    @switch($plan->Status)
        @case(1)
            Active
            @break

        @case(0)
            Inactive
            @break

        @default
            Unknown Status
    @endswitch
</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" style="width: 23px; height: 16px;">
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('plans.edit', $plan->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                                    <a href="{{ route('plans.show', $plan->id) }}" class="dropdown-item"><i class="mdi mdi-account-eye me-1"></i> View</a>
                                                    <form id="delete-form" action="{{ route('plans.destroy', $plan->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this plan?')"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
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
@endsection
