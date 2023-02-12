<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

// use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $languages = ['ar', 'en'];

        date_default_timezone_set('Africa/Cairo');

        $lang = request()->header('lang');

        if ($lang) {

            if (in_array($lang, $languages)) {
                App::setLocale($lang);

            } else {

                App::setLocale('ar');
            }
        }

    }
}
