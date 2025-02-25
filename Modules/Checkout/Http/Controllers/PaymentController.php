<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Entities\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    /**
     * Affiche le formulaire de paiement.
     *
     * @param  float  $totalPrice
     * @return \Illuminate\View\View
     */
    public function showPaymentForm($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Commande non trouvée');
        }

        return view('payment.show', [
            'orderIdentifier' => $order->order_identifier,
            'totalPrice' => $order->total_price
        ]);
    }

    /**
     * Traite le paiement réussi.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success()
    {
        // Logique de traitement pour un paiement réussi
        return redirect()->route('order.success')->with('success', 'Paiement réussi!');
    }

    /**
     * Affiche la page d'échec du paiement.
     *
     * @return \Illuminate\View\View
     */
    /**
     * Enregistre les données de paiement confirmées.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_identifier' => 'required|exists:orders,order_identifier',
            'total' => 'required|numeric',
            'card_number' => 'required|regex:/^594\d{13}$/',
            'expiration_date' => 'required|date_format:m/Y|after:today',
            'cvv' => 'required|digits:3',
        ]);

        try {
            $payment = new Payment();
            $payment->order_identifier = $validated['order_identifier'];
            $payment->amount = $validated['total'];
            $payment->card_token = 'token_generated_here';  // Simuler la génération d'un token de paiement
            $payment->expiration_date = $validated['expiration_date'];
            $payment->save();

            // Création de la facture
            $user = Auth::user();
            $invoice = new Invoice([
                'order_identifier' => $payment->order_identifier,
                'total_price' => $payment->amount,
                'user_email' => $user->email,
                'user_name' => $user->name,
                'user_id' => $user->id
            ]);
            $invoice->save();

            return redirect()->route('order.success')->with('success', 'Paiement réussi et facture créée!');
        } catch (\Exception $e) {
            Log::error("Payment processing failed: {$e->getMessage()}", [
                'user_id' => Auth::id(),
                'order_id' => $validated['order_identifier']
            ]);
            return back()->withErrors('Erreur lors du traitement de votre paiement. Veuillez réessayer.');
        }
    }


}
