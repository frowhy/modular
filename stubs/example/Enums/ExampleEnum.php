<?php


namespace Modules\Example\Enums;


use Modules\Core\Enums\BaseEnum;

class ExampleEnum extends BaseEnum
{
    const EXAMPLE = 0;

    protected const __ = [
        self::EXAMPLE => 'example',
    ];
}
