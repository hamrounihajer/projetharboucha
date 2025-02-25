
@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Subscribed Users') }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Price</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription['id'] }}</td>
                                            <td>{{ $subscription['user'] }}</td>
                                            <td>{{ $subscription['plan'] }}</td>
                                            <td>{{ $subscription['price'] }}</td>
                                            <td>{{ $subscription['role'] }}</td>
                                            <td>{{ $subscription['created_at'] }}</td>
                                            <td>{{ $subscription['due_date'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
