@extends('layouts/contentNavbarLayout')

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.production.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.production.min.js"></script>
<script src="{{ mix('js/iconRenderer.js') }}"></script>

<script>
    $(document).ready(function() {
        // Intercept the delete form submission
        $('.delete-form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var url = $(this).attr('action'); // Get the form action URL

            // Send an AJAX request to delete the medical team
            $.ajax({
                url: url,
                type: 'DELETE',
                data: $(this).serialize(),
                success: function(response) {
                    // Show an alert to indicate successful deletion
                    alert(response.message);

                    // Reload the page if necessary
                    location.reload();
                },
                error: function(xhr) {
                    // Show an alert with the error message in case of error
                    alert('An error occurred during deletion.');
                }
            });
        });

        // Search functionality
        function performSearch() {
            var searchName = $('#search-name').val().toLowerCase();
            var searchEmail = $('#search-email').val().toLowerCase();
            var searchPhone = $('#search-phone').val().toLowerCase();
            var rows = $('#medical-team-table tbody tr');

            rows.each(function() {
                var name = $(this).find('td').eq(0).text().toLowerCase();
                var email = $(this).find('td').eq(1).text().toLowerCase();
                var phone = $(this).find('td').eq(2).text().toLowerCase();
                var match = true;

                if (searchName && !name.includes(searchName)) match = false;
                if (searchEmail && !email.includes(searchEmail)) match = false;
                if (searchPhone && !phone.includes(searchPhone)) match = false;

                if (match) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $('#search-button').click(performSearch);

        $('.search-input').keypress(function(event) {
            if (event.keyCode === 13) { // Enter key
                performSearch();
            }
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $medicalType->name }}</div>
                <div class="card-body">
                    @if ($medicalTeam->isEmpty())
                        <p>No medical team found for this medical type!</p>
                    @else
                        <table class="table" id="medical-team-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="text" id="search-name" class="form-control search-input" placeholder="Search Name">
                                    </th>
                                    <th>
                                        <input type="text" id="search-email" class="form-control search-input" placeholder="Search Email">
                                    </th>
                                    <th>
                                        <input type="text" id="search-phone" class="form-control search-input" placeholder="Search Phone Number">
                                    </th>
                                    <th>
                                        <button id="search-button" class="btn btn-purple">Search</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicalTeam as $team)
                                <tr>
                                    <td>{{ $team->user->name }}</td>
                                    <td>{{ $team->user->email }}</td>
                                    <td>{{ $team->user->Phone }}</td>
                                    <td>
                                        @if(request()->routeIs('medical-team.*'))
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <span style="width: 20px;"></span>
                                                    <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" style="width: 23px; height: 16px;">
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('medical-team.editForm', $team->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                                    <a href="{{ route('medical-team.showDetails', $team->id) }}" class="dropdown-item"><i class="mdi mdi-account-eye me-1"></i> View</a>
                                                    <form class="delete-form" action="{{ route('medical-team.destroy', $team->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this medical team member?')"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    .btn-purple:hover {
        background-color: #563d7c;
        color: white;
    }
    .align-self-end {
        align-self: flex-end;
    }
</style>

@endsection
