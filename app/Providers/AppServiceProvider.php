<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $view_name = ['plantshop.includes.navbar', 'plantshop.includes.main'];
        
        /**
         * @todo Handle share data to specific or all view 
         * @param view needed to add specific view [array] or can be used for all views with "*" wildcard
         * Composer class created manually on 'App\Http\ViewComposers'
         */
        
        View::composer(
            $view_name, 'App\Http\ViewComposers\PlantShopViewComposer'
        );
    }
}
