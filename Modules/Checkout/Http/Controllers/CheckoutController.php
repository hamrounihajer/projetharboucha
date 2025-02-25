<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Plan;
use Modules\Checkout\Entities\TaxRule;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
  public function show(Request $request, $planId)
  {
      try {
          $plan = Plan::findOrFail($planId);
      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return redirect()->back()->with('error', 'Plan not found');
      }

      $user = Auth::user();
      $roleName = $user->role->name;
      $countryId = null;
      $currency = null;

      switch ($roleName) {
        case 'pharmacy':
            $currency = optional($user->pharmacy)->currency->symbol ?? '€'; // Utiliser un symbole par défaut si non trouvé
            break;
        case 'clinique':
            $currency = 'dt';
            break;
        default:
            $currency = optional($user->medicalTeam)->currency->symbol ?? '€';
            break;
      }

      switch ($roleName) {
          case 'pharmacy':
              $countryId = $user->pharmacy->country_id ?? null;
              break;
          case 'clinique':
              $countryId = '224';
              break;
          default:
              $countryId = $user->medicalTeam->country_id ?? null;
              break;
      }

      if (!$countryId) {
          return redirect()->back()->with('error', 'No country associated with the user');
      }
      $totalTaxes = 0;

      $taxRules = TaxRule::with('tax')->where('country_id', $countryId)->get();

      $taxDetails = [];

      foreach ($taxRules as $rule) {
          if (isset($rule->tax)) {
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

      $totalPrice = $plan->price ;
      $priceExcludingTaxes = $plan->price - $totalTaxes;
      $orderIdentifier = 'OR' . sprintf('%05d', mt_rand(0, 99999));

      return view('checkout.checkout', [
          'plan' => $plan,

          'totalTaxes' => $totalTaxes,
          'priceExcludingTaxes' => $priceExcludingTaxes,
          'totalPrice' => $totalPrice,
          'currency' => $currency,
          'orderIdentifier' => $orderIdentifier,
          'taxDetails' => $taxDetails
      ]);
  }
}
