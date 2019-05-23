<?php

namespace Modules\Example\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * 绑定服务接口.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Modules\Example\Services\ExampleService::class, \Modules\Example\Services\ExampleServiceI::class);
        //
    }
}
