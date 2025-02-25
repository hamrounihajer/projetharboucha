<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Invoice;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Fetch all invoices along with their associated user and plan details
        $subscriptions = Invoice::with(['user', 'plan'])->get();  // Assuming you have 'user' and 'plan' relationships defined in your Invoice model

        return view('subscription.index', compact('subscriptions'));
    }
}
