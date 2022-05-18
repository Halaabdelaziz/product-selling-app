<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RespositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Http\Interfaces\API\ProductInterface','App\Http\Repositories\API\ProductRepository');
        $this->app->bind('App\Http\Interfaces\API\UserInterface','App\Http\Repositories\API\UserRepository');
        $this->app->bind('App\Http\Interfaces\API\ImageInterface','App\Http\Repositories\API\ImageRepository');


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
