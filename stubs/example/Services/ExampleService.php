<?php

namespace Modules\Example\Services;

use Modules\Core\Supports\Response;

interface ExampleService
{
    public function index(): Response;

    public function store(array $attributes): Response;

    public function show(int $id): Response;

    public function update(int $id, array $attributes): Response;

    public function destroy(int $id): Response;
}
