<?php

namespace Modules\Example\Presenters;

use Modules\Example\Transformers\ExampleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ExamplePresenter
 *
 * @package Modules\Example\Presenters;
 */
class ExamplePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ExampleTransformer();
    }
}
