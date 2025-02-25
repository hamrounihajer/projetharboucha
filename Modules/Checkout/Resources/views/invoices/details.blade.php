@extends('dashboardClientLayouts.app')

@section('content')
<div class="container">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/img/avatars/logoIchifa.png') }}" style="max-width:150px;">
                            </td>
                            <td class="company-info">
                                <strong>Company Name:</strong> ChifaI<br>
                                <strong>Street:</strong> Av. de la Corniche, Monastir<br>
                                <strong>Zip Code:</strong> 5000<br>
                                <strong>Phone:</strong> 20331529
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2" class="invoice-details">
                    <strong>Invoice : </strong> <span class="invoice-reference">{{ $invoice->reference }}</span><br>
                    <strong>Order : </strong>{{ $invoice->order->order_identifier }}<br>
                    <strong>Invoice date : </strong>{{ $invoice->created_at->format('j F Y') }}<br>
                    <strong>Due date : </strong>{{
                        $invoice->created_at->addMonths(
                            $invoice->order->plan->periodicity_type === 'Monthly' ? 1 :
                            ($invoice->order->plan->periodicity_type === 'Quarterly' ? 3 :
                            ($invoice->order->plan->periodicity_type === 'Annually' ? 12 : 0))
                        )->format('j F Y')
                    }}
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                            <strong>User name : </strong>{{ $invoice->user->name }}<br>
                            <strong>Address : </strong>{{ $invoice->user->address }}
                            </td>
                            <td>
                            <strong>Email : </strong>{{ $invoice->user->email }}<br>
                            <strong>Phone number : </strong>{{ $invoice->user->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Plan Name :</td>
                <td>Price (Excl. Taxes) :</td>
            </tr>

            <tr class="item">
                <td>{{ $invoice->order->plan->name }}</td>
                <td>{{ number_format($priceExcludingTaxes, 2) }} TND</td>
            </tr>

            @if(!empty($taxDetails))
                <tr class="heading">
                    <td>Taxes :</td>
                    <td>Amount :</td>
                </tr>
                @foreach($taxDetails as $tax)
                    <tr class="item">
                        <td>{{ $tax['name'] }}</td>
                        <td>{{ number_format($tax['amount'], 2) }} TND</td>
                    </tr>
                @endforeach
            @endif

            <tr class="total">
                <td></td>
                <td>Total (Incl. Taxes): {{ number_format($totalPrice, 2) }} TND</td>
            </tr>
        </table>
        <div class="signature">
            <p>Signature:</p>
            <div class="signature-text">ChifaI</div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .invoice-box {
        max-width: 600px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr.top table td.title {
        font-size: 25px;
    }
    .invoice-box table tr.information table td.invoice-details strong {
    color: #226D68; /* Change the color to red */
    font-weight: bold;
    text-decoration: underline; /* Add underline */
    font-style: italic; /* Add italic style */
    }
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    .signature {
        padding-top: 20px;
        text-align: center;
    }
    .signature-text {
        font-family: 'Brush Script MT', cursive;
        font-size: 24px;
        color: #000;
        position: relative;
        display: inline-block;
    }
    .signature-text:after {
        content: '';
        display: block;
        width: 100%;
        height: 2px;
        background: #333;
        margin-top: 5px;
    }
</style>
@endsection
