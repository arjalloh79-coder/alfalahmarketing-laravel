<?php

namespace App\Http\Controllers;

use App\Support\CookieConsent;
use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    /**
     * Accept tracking consent and set cookie.
     */
    public function accept(Request $request)
    {
        $consent = CookieConsent::accept();

        return response()->json(['status' => 'accepted'])
            ->cookie($consent['tracking_consent'], $consent['expires']->timestamp, $consent['path'], null, $consent['secure'], $consent['httpOnly'], false, $consent['sameSite']);
    }

    /**
     * Reject tracking consent and set cookie.
     */
    public function reject(Request $request)
    {
        $consent = CookieConsent::reject();

        return response()->json(['status' => 'rejected'])
            ->cookie($consent['tracking_consent'], $consent['expires']->timestamp, $consent['path'], null, $consent['secure'], $consent['httpOnly'], false, $consent['sameSite']);
    }
}
