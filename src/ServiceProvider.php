<?php

namespace Frowhy\Modular;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/repository.php' => config_path('repository.php'),
        ], 'modular-config');
        $this->publishes([
            dirname(__DIR__).'/config/modules.php' => config_path('modules.php'),
        ], 'modular-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/repository.php', 'repository'
        );
    }
}
