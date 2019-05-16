<?php

namespace Modules\Example\Repositories;

use Modules\Core\Traits\RepositoryStructureTrait;
use Modules\Example\Entities\Example;
use Modules\Example\Presenters\ExamplePresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ExampleRepositoryEloquent extends BaseRepository implements ExampleRepository
{
    use RepositoryStructureTrait;

    /**
     * Specify Model
     *
     * @return string
     */
    public function model()
    {
        return Example::class;
    }

    /**
     * Specify Presenter
     *
     * @return mixed
     */
    public function presenter()
    {
        return ExamplePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     */
    public function boot()
    {
        $this->pushCriteria(app('Prettus\\Repository\\Criteria\\RequestCriteria'));
    }
}
