<?php

namespace Modules\Example\Http\Controllers;

use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Modules\Core\Supports\Response;

class ExampleController extends Controller
{
    /**
     * Display info of the module.
     *
     * @return Response
     */
    public function index()
    {
        $name = Module::find('example')->name;
        $requirements = collect(Module::findRequirements('example'));
        $requirements = $requirements->map(function ($item) {
            return $item->name;
        });
        $routes = get_routes('example');

        return Response::handleOk(compact('name', 'requirements', 'routes'));
    }
}
