<?php

namespace App\Http\Controllers\FrontEnd\Language;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\ChangeLocale;

// use Illuminate\Support\Facades\Session;
use Session;

class LanguageController extends Controller {

    public function switchLang($lang,
        ChangeLocale $changeLocale){
        // $languages = Language::Lists('id','code');
        // if (array_key_exists($lang, $languages)) {
        //     Session::set('applocale', $lang);
        //     Session::set('applangId', $languages[$lang]);
        // }else{
        // Session::set('applocale', $lang);
        // Session::set('applangId', $lang);
        // session()->set('applangId', $lang);
        session(['applangId' => $lang]);

        // }
        return redirect('/');

        // $lang = in_array($lang, config('app.languages')) ? $lang : config('app.fallback_locale');
        // $lang = in_array($lang, 'en') ? $lang : 'en';
        // $changeLocale->lang = $lang;
        // $this->dispatch($changeLocale);
        // return redirect()->back();
    }
}
