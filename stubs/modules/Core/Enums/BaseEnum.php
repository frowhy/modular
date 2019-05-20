<?php


namespace Modules\Core\Enums;


use Illuminate\Support\{Arr, Str};

class BaseEnum
{
    protected const __ = [];

    public static function __(int $enum): string
    {
        $callClass = get_called_class();
        $module = strtolower(Str::before(Str::after($callClass, 'Modules\\'), '\\'));
        $scope = Str::camel(Str::before(Str::after($callClass, 'Enums\\'), 'Enum'));

        if (!Arr::has(static::__, $enum)) {
            return __('core::default.translator_key_is_not_found');
        }

        $key = static::__[$enum];

        return __("{$module}::{$scope}.{$key}");
    }
}
