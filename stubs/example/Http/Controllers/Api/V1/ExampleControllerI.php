<?php

namespace Modules\Example\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Core\Supports\Response;
use Modules\Core\Supports\ResponsibilityChain;
use Modules\Example\Http\Requests\ExampleStoreRequest;
use Modules\Example\Http\Requests\ExampleUpdateRequest;
use Modules\Example\Services\ExampleService;

class ExampleControllerI extends Controller implements ExampleController
{
    public function index(ResponsibilityChain $responsibilityChain, ExampleService $exampleService): Response
    {
        $step1 = function () use ($exampleService) {
            return $exampleService->index();
        };

        return $responsibilityChain->append($step1)->handle();
    }

    public function store(
        ResponsibilityChain $responsibilityChain,
        ExampleService $exampleService,
        ExampleStoreRequest $exampleStoreRequest
    ): Response {
        $attributes = $exampleStoreRequest->validated();

        $step1 = function () use ($exampleService, $attributes) {
            return $exampleService->store($attributes);
        };

        return $responsibilityChain->append($step1)->handle();
    }

    public function show(ResponsibilityChain $responsibilityChain, ExampleService $exampleService, int $id): Response
    {
        $step1 = function () use ($exampleService, $id) {
            return $exampleService->show($id);
        };

        return $responsibilityChain->append($step1)->handle();
    }

    public function update(
        ResponsibilityChain $responsibilityChain,
        ExampleService $exampleService,
        int $id,
        ExampleUpdateRequest $exampleUpdateRequest
    ): Response {
        $attributes = $exampleUpdateRequest->validated();

        $step1 = function () use ($exampleService, $id, $attributes) {
            return $exampleService->update($id, $attributes);
        };

        return $responsibilityChain->append($step1)->handle();
    }

    public function destroy(ResponsibilityChain $responsibilityChain, ExampleService $exampleService, int $id): Response
    {
        $step1 = function () use ($exampleService, $id) {
            return $exampleService->destroy($id);
        };

        return $responsibilityChain->append($step1)->handle();
    }
}
