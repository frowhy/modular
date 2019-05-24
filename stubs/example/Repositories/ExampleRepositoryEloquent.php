<?php

namespace Modules\Example\Repositories;

use Modules\Example\Entities\Example;
use Modules\Example\Presenters\ExamplePresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ExampleRepositoryEloquent extends BaseRepository implements ExampleRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

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
}
