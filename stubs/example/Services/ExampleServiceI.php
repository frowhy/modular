<?php

namespace Modules\Example\Services;

use Modules\Core\Supports\Response;
use Modules\Example\Repositories\ExampleRepository;

class ExampleServiceI implements ExampleService
{
    /**
     * @var \Modules\Example\Repositories\ExampleRepository
     */
    private $exampleRepository;

    public function __construct(ExampleRepository $dataRepository)
    {
        $this->exampleRepository = $dataRepository;
    }

    public function index(): Response
    {
        return Response::handleOk($this->exampleRepository->all());
    }

    public function store(array $attributes): Response
    {
        return Response::handleCreated($this->exampleRepository->create($attributes));
    }

    public function show(int $id): Response
    {
        return Response::handleOk($this->exampleRepository->find($id));
    }

    public function update(int $id, array $attributes): Response
    {
        return Response::handleResetContent($this->exampleRepository->update($attributes, $id));
    }

    public function destroy(int $id): Response
    {
        return Response::handleNoContent($this->exampleRepository->delete($id));
    }
}
