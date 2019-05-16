<?php


namespace Modules\Core\Enums;


class BaseEnum
{
    protected const __ = [];

    public static function __(int $enum): string
    {
        $callClass = get_called_class();
        $module = strtolower(str_before(str_after($callClass, 'Modules\\'), '\\'));
        $scope = camel_case(str_before(str_after($callClass, 'Enums\\'), 'Enum'));

        if (!array_has(static::__, $enum)) {
            return __('core::default.translator_key_is_not_found');
        }

        $key = static::__[$enum];

        return __("{$module}::{$scope}.{$key}");
    }
}
