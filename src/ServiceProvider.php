<?php

namespace Frowhy\Modular;


use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/stubs/modules.php' => config_path('modules.php'),
        ]);
        $this->publishes([
            dirname(__DIR__).'/stubs/repository.php' => config_path('repository.php'),
        ]);
        $this->publishes([
            dirname(__DIR__).'/stubs/modules' => base_path('modules'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/stubs/modules.php', 'modules'
        );
        $this->mergeConfigFrom(
            dirname(__DIR__).'/stubs/repository.php', 'repository'
        );
    }
}