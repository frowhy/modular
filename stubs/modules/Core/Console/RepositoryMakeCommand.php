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

class RepositoryMakeCommand extends GeneratorCommand
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
    protected $name = 'module:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Repository for the specified module.';

    public function getDefaultNamespace(): string
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        return $laravelFileRepository->config('paths.generator.repository.path', 'Repositories');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
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
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model that should be assigned.', null],
            ['resource', 'r', InputOption::VALUE_NONE, 'Flag to create associated resource', null],
            ['presenter', 'p', InputOption::VALUE_NONE, 'Flag to create associated presenter', null],
        ];
    }

    private function handleOptionalResourceOption()
    {
        if ($this->option('resource') === true) {
            $resourceName = $this->getModelName().'Transformer';

            $this->call('module:make-resource', [
                'name' => $resourceName, 'module' => $this->argument('module'),
            ]);
        }
    }

    private function handleOptionalPresenterOption()
    {
        if ($this->option('presenter') === true) {
            $presenterName = $this->getModelName().'Presenter';

            $this->call('module:make-presenter', [
                'name' => $presenterName, 'module' => $this->argument('module'),
            ]);
        }
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
            'IMPLEMENT_CLASS' => $this->getClass().'Eloquent',
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

        $root_namespace = $laravelFileRepository->config('namespace');
        $root_namespace .= '\\'.$module->getStudlyName();

        return (new Stub('/repository-eloquent.stub', [
            'MODEL' => $this->getModelName(),
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
            'ROOT_NAMESPACE' => $root_namespace,
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

        return (new Stub('/repository.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
        ]))->render();
    }

    /**
     * @return string
     */
    private function getModelName()
    {
        return $this->option('model')
            ?: Str::before(class_basename($this->argument($this->argumentName)), 'Repository');
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        /** @var \Nwidart\Modules\Laravel\LaravelFileRepository $laravelFileRepository */
        $laravelFileRepository = $this->laravel['modules'];
        $path = $laravelFileRepository->getModulePath($this->getModuleName());
        $repositoryPath = GenerateConfigReader::read('repository');

        return $path.$repositoryPath->getPath().'/'.$this->getFileName().'.php';
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

        $path = Str::before($path, '.php').'Eloquent.php';
        $this->implementationHandle($path);

        $path = module_path($this->getModuleName()).'/Providers/RepositoryServiceProvider.php';
        $this->bindingsHandle($path);

        $this->handleOptionalResourceOption();
        $this->handleOptionalPresenterOption();
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
