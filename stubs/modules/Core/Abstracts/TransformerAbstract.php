<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/12/6
 * Time: 上午10:30
 */

namespace Modules\Core\Abstracts;

use Modules\Core\Traits\TransformerStructureTrait;
use League\Fractal\TransformerAbstract as BaseTransformerAbstract;

abstract class TransformerAbstract extends BaseTransformerAbstract
{
    use TransformerStructureTrait;

    abstract public function fields($attribute);
}
