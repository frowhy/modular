<?php

namespace Modules\Example\Providers;


use Illuminate\Support\ServiceProvider;

class ControllerServiceProvider extends ServiceProvider
{
    /**
     * 绑定控制器接口
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Modules\Example\Http\Controllers\Api\V1\ExampleController::class, \Modules\Example\Http\Controllers\Api\V1\ExampleControllerI::class);
        //
    }
}
