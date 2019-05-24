<?php

namespace Modules\Example\Http\Controllers\Api\V1;

use Modules\Core\Supports\Response;
use Modules\Core\Supports\ResponsibilityChain;
use Modules\Example\Http\Requests\ExampleStoreRequest;
use Modules\Example\Http\Requests\ExampleUpdateRequest;
use Modules\Example\Services\ExampleService;

interface ExampleController
{
    public function index(ResponsibilityChain $responsibilityChain, ExampleService $exampleService): Response;

    public function store(
        ResponsibilityChain $responsibilityChain,
        ExampleService $exampleService,
        ExampleStoreRequest $exampleStoreRequest
    ): Response;

    public function show(ResponsibilityChain $responsibilityChain, ExampleService $exampleService, int $id): Response;

    public function update(
        ResponsibilityChain $responsibilityChain,
        ExampleService $exampleService,
        int $id,
        ExampleUpdateRequest $exampleUpdateRequest
    ): Response;

    public function destroy(
        ResponsibilityChain $responsibilityChain,
        ExampleService $exampleService,
        int $id
    ): Response;
}
