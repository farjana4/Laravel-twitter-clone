<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function showHome()
    {
        $data = [];
        //business logic
        //$today_date = now()->format('d, M Y');
        //$data['today_date'] = strtotime(date('Y-m-d 01:00:00'));
        $data['currentDateTime'] = strtotime(date('Y-m-d h:i:s'));
        $data['todayDateOneAm'] = strtotime(date('Y-m-d 01:00:00'));
        $data['todayDateOneThirtyAm'] = strtotime(date('Y-m-d 01:30:00'));

        return view('home', $data);
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
