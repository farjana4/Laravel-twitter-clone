<?php

namespace App\Http\Controllers;

class TranslatesController extends Controller
{
    public function showTranslatesForm()
    {
        $data['user'] = auth()->user();
        /*$path = storage_path() . "/json/${filename}.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $json = json_decode(file_get_contents($path), true);*/

        // initialize your return variable

        // Read File
        $path = file_get_contents(base_path('resources/lang/en/twitter.json'));
        $data = json_decode($path, true);

        // Update Key
        $data['home'] = 'Change Home Title';

        // Write File
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents(base_path('resources/lang/en/twitter.json'), stripslashes($newJsonString));

        // Get Key Value

        dd(__('home'));

        return view('translates.translates', $data);
    }
}
