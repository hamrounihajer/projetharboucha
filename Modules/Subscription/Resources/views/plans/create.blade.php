@extends('layouts/contentNavbarLayout')

@section('page-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const featuresContainer = document.getElementById('features');
        const nameSelect = document.getElementById('name');
        const anotherNameDiv = document.getElementById('another-name-div');
        const priceHTInput = document.getElementById('price_HT');
        const priceTaxedInput = document.getElementById('price');
        const taxes = @json($taxes);

        nameSelect.addEventListener('change', function (event) {
            if (event.target.value === 'Another') {
                anotherNameDiv.style.display = 'block';
            } else {
                anotherNameDiv.style.display = 'none';
            }
        });

        featuresContainer.addEventListener('change', function (event) {
            if (event.target.type === 'checkbox') {
                const featureId = event.target.value;
                const featureChecked = event.target.checked;
                const featureName = event.target.getAttribute('data-feature-name');

                if (featureChecked) {
                    const featureCard = document.getElementById('feature-card-' + featureId);
                    const valueInput = document.createElement('input');
                    valueInput.type = 'text';
                    valueInput.name = 'feature_values[' + featureId + ']';
                    valueInput.id = 'feature-value-' + featureId;
                    valueInput.classList.add('form-control', 'mt-2');
                    valueInput.placeholder = 'Enter value for ' + featureName;
                    featureCard.appendChild(valueInput);
                } else {
                    const valueInput = document.getElementById('feature-value-' + featureId);
                    if (valueInput) {
                        valueInput.remove();
                    }
                }
            }
        });
        function calculateTotalWithTaxes(basePrice) {
        let totalTaxes = 0;
        taxes.forEach(tax => {
            if (tax.type === 'percentage') {
                // Calculate the percentage tax based on the taxed price
                totalTaxes += (basePrice * tax.rate / (100 - tax.rate));
            } else {
                // Add the fixed tax
                totalTaxes += parseFloat(tax.rate);
            }
        });
        // Return the total price with taxes
        return parseFloat(basePrice) + totalTaxes;
    }

    function calculateTaxedPrice(priceHT) {
        return calculateTotalWithTaxes(priceHT).toFixed(2);
    }



    function calculatePriceHT(priceTaxed) {
        let totalFixedTaxes = 0;
        let totalPercentageRates = 0;

        // Separate fixed taxes and percentage rates
        taxes.forEach(tax => {
            if (tax.type === 'percentage') {
                totalPercentageRates += tax.rate;
            } else {
                totalFixedTaxes += parseFloat(tax.rate);
            }
        });

        // Subtract fixed taxes from the taxed price
        let priceAfterFixedTaxes = priceTaxed - totalFixedTaxes;

        // Calculate the total percentage tax amount from the taxed price
        let percentageTaxAmount = priceTaxed * (totalPercentageRates / 100);

        // Calculate base price by subtracting the percentage tax amount from the price after fixed taxes
        let basePrice = priceTaxed - percentageTaxAmount - totalFixedTaxes;

        return basePrice.toFixed(2);
    }

    priceHTInput.addEventListener('input', function () {
        const priceHT = priceHTInput.value;
        if (priceHT) {
            priceTaxedInput.value = calculateTaxedPrice(priceHT);
        } else {
            priceTaxedInput.value = '';
        }
    });

    priceTaxedInput.addEventListener('input', function () {
        const priceTaxed = priceTaxedInput.value;
        if (priceTaxed) {
            priceHTInput.value = calculatePriceHT(priceTaxed);
        } else {
            priceHTInput.value = '';
        }
    });
});
</script>

<style>
    .feature-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
    }

    .feature-card:hover {
        transform: scale(1.02);
    }

    .feature-checkbox {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .feature-checkbox input {
        margin-right: 10px;
    }

    .feature-value-div {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f0f0f0;
    }

    .btn-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-inline {
    display: flex;
    flex-direction: row;
    gap: 10px; /* Adjust the space between the divs as needed */
}

.form-group {
    flex: 1;
}

.plabel{
      padding-right: 15px;

    }



</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Plan</div>
                <div class="card-body">
                    <form action="{{ route('plans.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <select name="name" id="name" class="form-control" required>
                                <option value="Basic">Basic</option>
                                <option value="Premium">Premium</option>
                                <option value="Advanced">Advanced</option>
                                <option value="Another">Another</option>
                            </select>
                        </div>
                        <div class="form-group" id="another-name-div" style="display: none;">
                            <label for="another_name">New Plan Name:</label>
                            <input type="text" name="another_name" id="another_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="grace_days">Grace Days:</label>
                            <input type="number" name="grace_days" id="grace_days" class="form-control" required>
                        </div>


                         <div  class="form-inline">
                        <div class="form-group" style="width:45%">
                            <label for="price_HT"  class="plabel">Price HT:</label>
                            <input type="number" step="0.01" name="price_HT" id="price_HT" class="form-control" required>
                        </div>
                        <div class="form-group" style="width:45%">
                            <label for="price"  class="plabel">Taxed Price:</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="periodicity">Periodicity</label>
                            <select name="periodicity" class="form-control" required>
                                <option value="1">Monthly</option>
                                <option value="3">Quarterly</option>
                                <option value="12">Annually</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="assigned_role">Assign to:</label>
                            <select name="assigned_role" id="assigned_role" class="form-control" required>
                                <option value="">Select a type</option>
                                @foreach($assignableRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="currency">Currency:</label>
                            <input type="text" name="currency" id="currency" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked onchange="toggleStatusLabel(this)">
                                <label class="custom-control-label" for="status" id="status-label">Active</label>
                            </div>
                        </div>

                        <script>
                            function toggleStatusLabel(checkbox) {
                                const label = document.getElementById('status-label');
                                if (checkbox.checked) {
                                    label.textContent = 'Active';
                                } else {
                                    label.textContent = 'Inactive';
                                }
                            }

                            // Ensure the correct label is set on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                const checkbox = document.getElementById('status');
                                toggleStatusLabel(checkbox);
                            });
                        </script>

                        <div class="form-group" id="features">
                            <label>Features:</label>
                            <div class="form-check">
                                @foreach($features as $feature)
                                    <div class="feature-card" id="feature-card-{{ $feature->id }}">
                                        <span style= "width: 35px"></span>
                                        <div class="feature-checkbox">
                                            <input class="form-check-input" type="checkbox" name="features[]" id="feature_{{ $feature->id }}" value="{{ $feature->id }}" data-feature-name="{{ $feature->name }}">
                                            <label class="form-check-label" for="feature_{{ $feature->id }}">
                                                {{ $feature->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="feature-values"></div>
                        <hr>
                        <div class="btn-center">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
