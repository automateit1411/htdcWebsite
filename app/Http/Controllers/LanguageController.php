<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        if (!in_array($locale, ['en', 'bn'])) {
            abort(400);
        }

        // Save to database (global setting)
        $setting = Setting::first();
        if ($setting) {
            $setting->update(['site_language' => $locale]);
        }

        // Also set for current session
        app()->setLocale($locale);

        return redirect()->back();
    }
}
