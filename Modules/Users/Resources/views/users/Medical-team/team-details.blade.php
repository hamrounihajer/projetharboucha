@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="neon-title"style="color:white" >{{ $medicalTeam->user->name }} -  Details</h2>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $medicalTeam->user->name }}</p>
                    <p><strong>Email:</strong> {{ $medicalTeam->user->email }}</p>
                    <p><strong>Phone Number:</strong> {{ $medicalTeam->user->Phone }}</p>
                    <p><strong>Gender:</strong> {{ $medicalTeam->user->gender }}</p>

                    <div class="form-group mb-3">
                        <p><strong>Country:</strong> {{ optional($medicalTeam->medicalAddress->country)->name ?? 'N/A' }}</p>
                        <p><strong>State:</strong> {{ optional($medicalTeam->medicalAddress->state)->name ?? 'N/A' }}</p>
                        <p><strong>Dependency:</strong> {{ optional($medicalTeam->medicalAddress->dependency)->name ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ optional($medicalTeam->medicalAddress->city)->name ?? 'N/A' }}</p>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="{{ route('medical-team.editForm', $medicalTeam->id) }}" class="btn btn-purple">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .neon-title {
        font-family: 'Arial', sans-serif;
        color: #fff;
        text-shadow:
            0 0 5px rgba(255, 255, 255, 0.6),
            0 0 10px rgba(255, 255, 255, 0.6),
            0 0 15px rgba(255, 255, 255, 0.6),
            0 0 20px rgba(255, 255, 255, 0.6),
            0 0 25px rgba(255, 255, 255, 0.6),
            0 0 30px rgba(255, 255, 255, 0.6),
            0 0 35px rgba(255, 255, 255, 0.6);
        animation: neon 1.5s ease-in-out infinite alternate;
    }

    @keyframes neon {
        from {
            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.6),
                0 0 10px rgba(255, 255, 255, 0.6),
                0 0 15px rgba(255, 255, 255, 0.6),
                0 0 20px rgba(255, 255, 255, 0.6),
                0 0 25px rgba(255, 255, 255, 0.6),
                0 0 30px rgba(255, 255, 255, 0.6),
                0 0 35px rgba(255, 255, 255, 0.6);
        }
        to {
            text-shadow:
                0 0 10px rgba(255, 255, 255, 0.9),
                0 0 20px rgba(255, 255, 255, 0.9),
                0 0 30px rgba(255, 255, 255, 0.9),
                0 0 40px rgba(255, 255, 255, 0.9),
                0 0 50px rgba(255, 255, 255, 0.9),
                0 0 60px rgba(255, 255, 255, 0.9),
                0 0 70px rgba(255, 255, 255, 0.9);
        }
    }

    .btn-purple {
        background-color: #6f42c1;
        color: white;
        border: none;
    }
    .btn-purple:hover {
        background-color: #563d7c;
        color: white;
    }
</style>
@endsection
