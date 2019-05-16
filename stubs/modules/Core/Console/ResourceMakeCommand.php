<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\ResourceMakeCommand as BaseResourceMakeCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;

class ResourceMakeCommand extends BaseResourceMakeCommand
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        parent::handle();

        $this->handleOptionalPresenterOption();
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
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model that should be assigned.', null],
            ['presenter', 'p', InputOption::VALUE_NONE, 'Flag to create associated presenter', null],
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

        return (new Stub('/resource.stub', [
            'MODEL' => $this->getModelName(),
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
            'ROOT_NAMESPACE' => $root_namespace,
        ]))->render();
    }

    /**
     * @return string
     */
    private function getModelName()
    {
        return $this->option('model')
            ?: Str::before(class_basename($this->argument($this->argumentName)), 'Transformer');
    }
}
