<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Settings::getAllGrouped();

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'default_currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'weekly_holiday' => 'nullable|integer|min:1|max:7',
            'default_working_hours' => 'nullable|numeric|min:0|max:24',
            'overtime_rate_multiplier' => 'nullable|numeric|min:0|max:10',
            'payment_terms' => 'nullable|string|max:50',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'payment_reminder_days' => 'nullable|integer|min:0|max:365',
        ]);

        // Handle checkbox separately
        $validated['enable_email_notifications'] = $request->has('enable_email_notifications');

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Settings::set($key, $value);
            }
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
