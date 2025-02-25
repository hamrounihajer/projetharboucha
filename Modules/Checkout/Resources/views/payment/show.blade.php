@extends('dashboardClientLayouts.app')

@section('page-script')
<!-- Include the Bootstrap Datepicker CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/datepicker.css') }}">
<!-- Include the required JavaScript files -->
<script src="{{ asset('assets/js/jquery.timepicker.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
<script>
$(document).ready(function() {
    $('.datePicker').datepicker({
      format: 'mm/yyyy',
      startView: "years",
      minViewMode: "months",
      autoclose: true,
      todayHighlight: true
  });
});
</script>
<script>
document.getElementById('paymentForm').addEventListener('submit', function(event) {
    var cardNumber = document.getElementById('card_number').value;
    var expirationDate = document.getElementById('expiration_date').value;
    var cvv = document.getElementById('cvv').value;

    // Regex for validating the card number and CVV
    var cardNumberRegex = /^594\d{13}$/;  // Example regex, adjust according to your needs
    var cvvRegex = /^\d{3}$/;

    // Field validation
    if (!cardNumberRegex.test(cardNumber) || !cvvRegex.test(cvv) || !expirationDate) {
        event.preventDefault();  // Prevent the form from submitting
        alert('Please correct the entered values.');  // Show an alert
    } else {
        // Here, the form will be submitted
    }
});
</script>

@endsection

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('assets/img/avatars/Paymee.png') }}" alt=" Logo" style="width: 150px;">
            </div>
            <h1 class="card-title text-center mb-4" style="color: #0056b3;">Payment Page</h1>
            <h4 class="text-center">Order ID: {{ $orderIdentifier }}</h4>
            <h4 class="text-center">Total Amount Due: {{ $totalPrice }} TND</h4>

            <form action="{{ route('payment.store') }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="order_identifier" value="{{ $orderIdentifier }}">
                <input type="hidden" name="total" value="{{ $totalPrice }}">

                <div class="mb-3">
                    <label for="card_number" class="form-label">Card Number:</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                </div>

                <div class="mb-3">
                    <label for="expiration_date">Expiration Date (MM/YYYY):</label>
                    <input type="text" class="form-control datePicker" id="expiration_date" name="expiration_date" required placeholder="MM/YYYY">
                </div>

                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV Code:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">Confirm Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
