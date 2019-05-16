<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PresenterMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-presenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Presenter for the specified module.';

    public function getDefaultNamespace(): string
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        return $laravelFileRepository->config('paths.generator.presenters.path', 'Presenters');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the presenter.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['resource', null, InputOption::VALUE_OPTIONAL, 'The resource that should be assigned.', null],
        ];
    }

    /**
     * @return mixed
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function getTemplateContents()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $module = $laravelFileRepository->findOrFail($this->getModuleName());

        $root_namespace = $laravelFileRepository->config('namespace');
        $root_namespace .= '\\'.$module->getStudlyName();

        return (new Stub('/presenter.stub', [
            'RESOURCE_NAME' => $this->getResourceName(),
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
            'ROOT_NAMESPACE' => $root_namespace,
        ]))->render();
    }

    /**
     * @return string
     */
    private function getResourceName()
    {
        return $this->option('resource')
            ?: Str::before(class_basename($this->argument($this->argumentName)), 'Presenter').'Transformer';
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $path = $laravelFileRepository->getModulePath($this->getModuleName());

        $presenterPath = GenerateConfigReader::read('presenters');

        return $path.$presenterPath->getPath().'/'.$this->getFileName().'.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
}
