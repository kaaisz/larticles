<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// to link migration with Schema without any matters:
use Illuminate\Support\Facades\Schema;

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
        // to link migration with Schema without any matters:
        Schema::defaultStringLength(191);
    }
}
