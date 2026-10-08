<?php

namespace App\Http\Controllers;

use App\Support\ContentStore;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $pricing = ContentStore::readJson('pricing');
        $currency = session('pricing_currency', app()->getLocale() === 'fr' ? 'gnf' : 'usd');

        return view('User.pricing', [
            'tiers' => $pricing['tiers'] ?? [],
            'government' => $pricing['government'] ?? [],
            'paymentMethods' => $pricing['payment_methods'] ?? [],
            'currency' => $currency,
            'currencies' => ['usd', 'gnf', 'sle'],
        ]);
    }

    public function setCurrency(Request $request)
    {
        $currency = $request->input('currency', 'usd');

        if (!in_array($currency, ['usd', 'gnf', 'sle'])) {
            return response()->json(['error' => 'Invalid currency'], 400);
        }

        session(['pricing_currency' => $currency]);

        return response()->json(['currency' => $currency, 'success' => true]);
    }
}
