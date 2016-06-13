<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Service\Admin\MenuSettingService', 'App\Service\Admin\MenuSettingService');
        $this->app->bind('App\Service\Common\CommonService', 'App\Service\Common\CommonService');

        $this->app->bind('App\Service\Admin\ActicleService', 'App\Service\Admin\ActicleService');
    }
}
