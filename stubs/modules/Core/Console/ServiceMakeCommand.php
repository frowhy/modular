<?php

namespace Modules\Core\Console;

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Exceptions\FileAlreadyExistException;
use Nwidart\Modules\Generators\FileGenerator;
use Nwidart\Modules\Support\{
    Config\GenerateConfigReader, Stub
};
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\{
    InputArgument, InputOption
};

class ServiceMakeCommand extends GeneratorCommand
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
    protected $name = 'module:make-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Service for the specified module.';

    public function getDefaultNamespace(): string
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        return $laravelFileRepository->config('paths.generator.services.path', 'Services');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @param $path
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    private function bindingsHandle($path)
    {
        $contents = $this->getBindingsTemplateContents();

        try {
            $contents = str_replace('//', $contents, File::get($path));
            File::replace($path, $contents);

            $this->info("Update : {$path}");
        } catch (FileNotFoundException $e) {
            $this->error("File : {$path} not found.");
        }
    }

    /**
     * Get bindings template contents.
     *
     * @return string
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function getBindingsTemplateContents()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $module = $laravelFileRepository->findOrFail($this->getModuleName());

        return (new Stub('/bindings.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'INTERFACE_CLASS' => $this->getClass(),
            'IMPLEMENT_CLASS' => $this->getClass().'I',
            'PLACEHOLDER' => '//',
        ]))->render();
    }

    /**
     * Get implementation template contents.
     *
     * @return string
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function getImplementTemplateContents()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $module = $laravelFileRepository->findOrFail($this->getModuleName());

        return (new Stub('/service/implement.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
        ]))->render();
    }

    /**
     * Get interface template contents.
     *
     * @return string
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function getInterfaceTemplateContents()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $module = $laravelFileRepository->findOrFail($this->getModuleName());

        return (new Stub('/service/interface.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $path = $laravelFileRepository->getModulePath($this->getModuleName());
        $apiPath = GenerateConfigReader::read('services');

        return $path.$apiPath->getPath().'/'.$this->getFileName().'.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }

    /**
     * Execute the console command.
     *
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    public function handle()
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());
        $this->interfaceHandle($path);

        $path = Str::before($path, '.php').'I.php';
        $this->implementationHandle($path);

        $path = module_path($this->getModuleName()).'/Providers/ServiceProvider.php';
        $this->bindingsHandle($path);
    }

    /**
     * Execute the console interface command.
     *
     * @param $path
     *
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function interfaceHandle($path)
    {
        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = $this->laravel['files'];
        if (!$filesystem->isDirectory($dir = dirname($path))) {
            $filesystem->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getInterfaceTemplateContents();

        try {
            with(new FileGenerator($path, $contents))->generate();

            $this->info("Created : {$path}");
        } catch (FileAlreadyExistException $e) {
            $this->error("File : {$path} already exists.");
        }
    }

    /**
     * Execute the console implementation command.
     *
     * @param $path
     *
     * @throws \Nwidart\Modules\Exceptions\ModuleNotFoundException
     */
    protected function implementationHandle($path)
    {
        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = $this->laravel['files'];
        if (!$filesystem->isDirectory($dir = dirname($path))) {
            $filesystem->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getImplementTemplateContents();

        try {
            with(new FileGenerator($path, $contents))->generate();

            $this->info("Created : {$path}");
        } catch (FileAlreadyExistException $e) {
            $this->error("File : {$path} already exists.");
        }
    }

    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        return '';
    }
}
