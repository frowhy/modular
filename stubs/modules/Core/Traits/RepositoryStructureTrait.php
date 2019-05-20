<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/11/27
 * Time: 下午7:20
 */

namespace Modules\Core\Traits;

use Illuminate\Support\Str;
use Modules\Core\Contracts\Repository\Filter;

/**
 * Trait RepositoryStructureTrait
 *
 * @package Modules\Core\Traits
 * @method \Prettus\Repository\Eloquent\BaseRepository pushCriteria($criteria)
 */
trait RepositoryStructureTrait
{
    public function only(array $attributes)
    {
        $model = Str::before(class_basename(get_called_class()), 'Repository');
        $filter = app(Filter::class);
        $filter->requestedFields[$model] = $attributes;

        return $this;
    }

    public function except(array $attributes)
    {
        $model = Str::before(class_basename(get_called_class()), 'Repository');
        $filter = app(Filter::class);
        $filter->excludeFields[$model] = $attributes;

        return $this;
    }
}
