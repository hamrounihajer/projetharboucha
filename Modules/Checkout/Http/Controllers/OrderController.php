<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Order;
use Illuminate\Support\Facades\Redirect;
use Modules\Checkout\Entities\Plan;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Confirme une commande et la traite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'total' => 'required|numeric'
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->status = 'pending';
        $order->total_price = $validated['total'];
        $order->plan_id = $validated['plan_id'];
        $order->save();

        // Assurez-vous de passer l'orderId à la route
        return redirect()->route('payment.show', ['orderId' => $order->id]);
    }

    /**
     * Affiche un formulaire pour passer une commande (hypothétique).
     *
     * @return \Illuminate\View\View
     */
    public function orderSuccess()
    {
        return view('order.success');  // Assurez-vous que cette vue existe dans resources/views/order/success.blade.php
    }
}
