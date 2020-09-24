<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $domain = str_replace(".", '_', \request()->getHost());
//        $views = [resource_path("views/{$domain}")];
//        $this->loadViewsFrom($views, 'domained');
    }
}
