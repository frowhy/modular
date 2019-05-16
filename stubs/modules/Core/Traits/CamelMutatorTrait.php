<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2019/2/26
 * Time: 11:10 AM
 */

namespace Modules\Core\Traits;

use Illuminate\Support\Str;

trait CamelMutatorTrait
{
    public function getAttribute($key)
    {
        $key = Str::snake($key);

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        $key = Str::snake($key);

        return parent::setAttribute($key, $value);
    }
}
