<?php

namespace Modules\Example\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;
use Modules\Core\Enums\StatusCodeEnum;
use Modules\Example\Database\Seeders\ExampleTableSeederTableSeeder;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $connectionsToTransact = [null];
    protected $dropViews = false;
    protected $dropTypes = false;

    private $baseUri = 'api/v1/';
    private $resource = 'examples';
    private $uri;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function __construct()
    {
        $this->uri = $this->baseUri.Str::plural($this->resource);
    }

    public function testIndex()
    {
        $this->get("{$this->uri}")->assertStatus(StatusCodeEnum::HTTP_OK);
    }

    public function testStore()
    {
        $this->post("{$this->uri}", ['name' => 'demo', 'value' => 'hello world'])
             ->assertStatus(StatusCodeEnum::HTTP_CREATED);
    }

    public function testShow()
    {
        $this->seed(ExampleTableSeederTableSeeder::class);

        $this->get("{$this->uri}/1")->assertStatus(StatusCodeEnum::HTTP_OK);
    }

    public function testUpdate()
    {
        $this->seed(ExampleTableSeederTableSeeder::class);

        $this->put("{$this->uri}/1", ['value' => 'Hello World'])->assertStatus(StatusCodeEnum::HTTP_RESET_CONTENT);
    }

    public function testDestroy()
    {
        $this->seed(ExampleTableSeederTableSeeder::class);

        $this->delete("{$this->uri}/1")->assertStatus(StatusCodeEnum::HTTP_NO_CONTENT);
    }
}
