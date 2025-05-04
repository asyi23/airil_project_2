<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Paginator::useBootstrap();

        if (env('FORCE_SSL', false)) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        Validator::extend('phone_number', function ($attribute, $value, $parameters) {
            return substr($value, 0, 2) != '60' && substr($value, 0, 1) != '6' && substr($value, 0, 1) != '0';
        }, 'The :attribute cannot start with 6, 0 or 60');
    }
}
