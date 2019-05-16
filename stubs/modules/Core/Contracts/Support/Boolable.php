<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2019/1/23
 * Time: 3:16 PM
 */

namespace Modules\Core\Contracts\Support;

interface Boolable
{
    /**
     * Get the true and false of the instance.
     *
     * @return bool
     */
    public function toBool(): bool;
}
