<?php

namespace Frowhy\Modular;


use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/modules.php' => config_path('modules.php'),
        ], 'config');
        $this->publishes([
            dirname(__DIR__).'/config/repository.php' => config_path('repository.php'),
        ], 'config');
        $this->publishes([
            dirname(__DIR__).'/stubs/modules' => base_path('modules'),
        ], 'initialize');
        $this->publishes([
            dirname(__DIR__).'/stubs/Example' => base_path('modules/Example'),
        ], 'example');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/modules.php', 'modules'
        );
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/repository.php', 'repository'
        );
    }
}