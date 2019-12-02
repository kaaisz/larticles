<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// to link migration with Schema without any matters:
use Illuminate\Support\Facades\Schema;
// to disable wrapping, use code below:(https://laravel.com/docs/5.8/eloquent-resources#data-wrapping)
// use Illuminate\Http\Resources\Json\Resource;

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
        // this code below will be enable providing object without wrapping
        // Resource::withoutWrapping();
    }
}
