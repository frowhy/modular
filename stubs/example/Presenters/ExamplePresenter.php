<?php

namespace Modules\Example\Presenters;

use Modules\Example\Transformers\ExampleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ExamplePresenter.
 */
class ExamplePresenter extends FractalPresenter
{
    /**
     * Transformer.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ExampleTransformer();
    }
}
