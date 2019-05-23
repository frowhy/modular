<?php

namespace Modules\Example\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * 绑定仓库接口.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Modules\Example\Repositories\ExampleRepository::class, \Modules\Example\Repositories\ExampleRepositoryEloquent::class);
        //
    }
}
