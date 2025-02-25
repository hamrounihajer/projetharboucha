<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Invoice;
use Modules\Checkout\Entities\TaxRule;

class InvoiceController extends Controller
{
    public function index($user_id)
    {
        $invoices = Invoice::where('user_id', $user_id)->get();

        if ($invoices->isEmpty()) {
            return view('Dashboard.invoices')->with('message', 'No invoices available.');
        }

        return view('Dashboard.invoices', compact('invoices'));
    }

    public function show($invoiceId)
    {
        $invoice = Invoice::with(['user', 'order.plan', 'order.taxes'])->findOrFail($invoiceId);
        $plan = $invoice->order->plan;
        $user = $invoice->user;

        // Determine country based on user's association (pharmacy, laboratory, or medical team)
        $countryId = $user->pharmacy->country_id ?? $user->laboratory->country_id ?? $user->medicalTeam->country_id ?? null;

        if (!$countryId) {
            return back()->with('error', 'No country associated with the user');
        }

        // Fetch tax rules for the associated country and plan
        $taxRules = TaxRule::with('tax')->where('country_id', $countryId)->get();
        $totalTaxes = 0;
        $taxDetails = [];

        foreach ($taxRules as $rule) {
            if ($rule->tax) {
                $calculatedTax = $rule->tax->calculateFor($plan->price);
                $totalTaxes += $calculatedTax;
                $taxDetails[] = [
                    'name' => $rule->tax->name,
                    'rate' => $rule->tax->rate,
                    'type' => $rule->tax->type,
                    'amount' => $calculatedTax
                ];
            }
        }

        $priceExcludingTaxes = $plan->price - $totalTaxes ;
        $totalPrice = $plan->price ;

        return view('invoices.details', [
            'invoice' => $invoice,
            'taxDetails' => $taxDetails,
            'priceExcludingTaxes' => $priceExcludingTaxes,
            'totalTaxes' => $totalTaxes,
            'totalPrice' => $totalPrice
        ]);
    }
    public function createInvoice($orderDetails)
    {
        $reference = 'FR' . sprintf('%05d', rand(10000, 99999)); // Génère un numéro entre 10000 et 99999

        $invoice = new Invoice([
            'order_identifier' => $orderDetails->order_identifier,
            'total_price' => $orderDetails->total_price,
            'user_id' => $orderDetails->user_id,
            'reference' => $reference
        ]);

        $invoice->save();

        return $invoice;
    }
    public function viewSubscribed()
{
    // Récupérer toutes les factures associées aux abonnements
    $invoices = Invoice::has('order.plan')->get();

    // Transformer les données des factures pour obtenir les détails requis
    $subscriptions = $invoices->map(function ($invoice) {
        return [
            'id' => $invoice->id,
            'user' => $invoice->user->name,
            'plan' => $invoice->order->plan->name,
            'price' => $invoice->order->total_price, // Utilisez total_price au lieu de price
            'role' => $invoice->user->role->name,
            'created_at' => $invoice->created_at->format('Y-m-d'), // Format de la date de création
            'due_date' => $invoice->created_at->addMonths(
                $invoice->order->plan->periodicity_type === 'Monthly' ? 1 :
                ($invoice->order->plan->periodicity_type === 'Quarterly' ? 3 :
                ($invoice->order->plan->periodicity_type === 'Annually' ? 12 : 0))
            )->format('Y-m-d'), // Format de la date d'échéance
        ];
    });

    // Retourner la vue avec les données des abonnements
    return view('subscribed.index', ['subscriptions' => $subscriptions]);
}




}
