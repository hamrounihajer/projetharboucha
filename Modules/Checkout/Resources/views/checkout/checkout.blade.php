@extends('dashboardClientLayouts.app')

@section('styles')
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f4f4f4;
        margin: 0;
        font-family: 'Open Sans', sans-serif;
    }
    .checkout-container {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        text-align: center;
        margin: auto;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .plan-name {
        color: #00BFFF;
        font-weight: bold;
    }
    .alert {
        padding: 10px;
        color: white;
        margin-bottom: 15px;
        border-radius: 5px;
    }
    .alert-success {
        background-color: #28a745;
    }
    .alert-danger {
        background-color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <h1>Checkout Page</h1>
    <h3>Order ID: {{ $orderIdentifier }}</h3>
    <hr>
    <h4 class="plan-name">Plan: {{ $plan->name }}</h4>
    <br>

   <!-- heeeere -->
   <h5>Taxes Details</h5>
    <ul style="list-style-type: none; padding-left: 0;">
        @foreach($taxDetails as $tax)
            <li>{{ $tax['name'] }}: @if($tax['type'] === 'percentage'){{ $tax['rate'] }}% - @endif {{ number_format($tax['amount'], 2, ',', ' ') }} {{ $currency }}</li>
        @endforeach
    </ul>

    <hr>
    <p>Total Taxes: {{ number_format($totalTaxes, 2, ',', ' ') }} {{ $currency }}</p>
    <p>Price (Excl. Taxes): {{ number_format($priceExcludingTaxes, 2, ',', ' ') }} {{ $currency }}</p>
    <p>Total Price (Incl. Taxes): {{ number_format($totalPrice, 2, ',', ' ') }} {{ $currency }}</p>
    <br>
    <h4>Status: Pending</h4>
    <br>
    <form id="paymentForm" method="POST" action="{{ route('order.confirm') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <input type="hidden" name="total" value="{{ $totalPrice }}">
        <input type="hidden" name="order_identifier" value="{{ $orderIdentifier }}" />
        <button type="submit" id="payNowButton" class="btn btn-primary">Pay Now</button>
    </form>
</div>

<script>
    document.getElementById('payNowButton').addEventListener('click', function() {
        var form = document.getElementById('paymentForm');
        form.action = "{{ route('order.confirm') }}";

        form.submit();
    });
</script>
@endsection
