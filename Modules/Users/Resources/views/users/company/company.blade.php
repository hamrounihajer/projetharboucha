@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - companies')

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Search functionality
        function performSearch() {
            var searchID = $('#search-id').val().toLowerCase();
            var searchName = $('#search-name').val().toLowerCase();
            var searchType = $('#search-type').val().toLowerCase();
            var searchManager = $('#search-manager').val().toLowerCase();
            var searchCreateDate = $('#search-create-date').val().toLowerCase();
            var rows = $('#companies-table tbody tr');

            rows.each(function() {
                var id = $(this).find('td').eq(0).text().toLowerCase();
                var name = $(this).find('td').eq(1).text().toLowerCase();
                var type = $(this).find('td').eq(2).text().toLowerCase();
                var manager = $(this).find('td').eq(3).text().toLowerCase();
                var createDate = $(this).find('td').eq(4).text().toLowerCase();
                var match = true;

                if (searchID && !id.includes(searchID)) match = false;
                if (searchName && !name.includes(searchName)) match = false;
                if (searchType && !type.includes(searchType)) match = false;
                if (searchManager && !manager.includes(searchManager)) match = false;
                if (searchCreateDate && !createDate.includes(searchCreateDate)) match = false;

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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Tables /</span> companies</h4>

<div class="text-end mb-3">
    <a href="{{ route('company.createForm') }}" class="btn btn-primary">Add Company</a>
</div>

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">Companies Table</h5>
    <div class="table-responsive text-nowrap">
        @if($companies->isEmpty())
            <p class="text-center mt-3">No companies available!</p>
        @else
            <table class="table" id="companies-table">
                <thead>
                    <tr>
                        <th>
                            <input type="text" id="search-id" class="form-control search-input" placeholder="Search ID">
                        </th>
                        <th>
                            <input type="text" id="search-name" class="form-control search-input" placeholder="Search Name">
                        </th>
                        <th>
                            <input type="text" id="search-type" class="form-control search-input" placeholder="Search Type">
                        </th>
                        <th>
                            <input type="text" id="search-manager" class="form-control search-input" placeholder="Search Manager">
                        </th>
                        <th>
                            <input type="text" id="search-create-date" class="form-control search-input" placeholder="Search Create Date">
                        </th>
                        <th>
                            <button id="search-button" class="btn btn-purple">Search</button>
                        </th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Manager</th>
                        <th>Create Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->company_name }}</td>
                            <td>{{ $company->company_type }}</td>
                            <td>{{ $company->manager }}</td>
                            <td>{{ $company->created_at }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <img src="{{ asset('images/trois-points.png') }}" alt="Menu Icon" style="width: 23px; height: 16px;">
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('company.editForm', $company->id) }}" class="dropdown-item"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                        <form action="{{ route('company.destroy', $company->id) }}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this company?')"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
