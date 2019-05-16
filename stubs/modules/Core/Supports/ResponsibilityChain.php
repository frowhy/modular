<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2019-03-08
 * Time: 11:23
 */

namespace Modules\Core\Supports;

use Closure;

class ResponsibilityChain
{
    private $isError = false;
    private $result = null;
    private $lastResult = null;

    public function append(Closure $result, bool $isLastResult = false, bool $isNext = false): ResponsibilityChain
    {
        if (!$this->isError || $isNext) {
            $this->result = $result(get_data($this->result), is_true($this->result));

            if (is_true($isLastResult)) {
                $this->lastResult = $this->result;
            }

            if (!is_true($this->result)) {
                $this->isError = true;
            }
        }

        return $this;
    }

    public function handle(): Response
    {
        if (!is_null($this->lastResult)) {
            return $this->lastResult;
        }

        return $this->result;
    }
}
