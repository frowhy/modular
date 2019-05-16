<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Module;
use Modules\Core\Enums\StatusCodeEnum;
use Modules\Core\Supports\Response;

class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Modules\Core\Supports\Response
     */
    public function index()
    {
        $name = Module::find('core')->name;
        $requirements = collect(Module::findRequirements('core'));
        $requirements = $requirements->map(function ($item) {
            return $item->name;
        });
        $routes = get_routes('core');

        return Response::handleOk(compact('name', 'requirements', 'routes'));
    }
}
