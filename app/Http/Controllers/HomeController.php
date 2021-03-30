<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function showHome()
    {
        return view('home');
    }

    public function setLocale(string $locale): RedirectResponse
    {
        $availableLocales = [
            'en', 'bn',
        ];
        $locale = in_array($locale, $availableLocales) ? $locale : 'en';
        /*Artisan::call('cache:clear');*/
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
