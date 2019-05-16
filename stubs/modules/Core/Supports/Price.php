<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/11/26
 * Time: 下午3:08
 */

namespace Modules\Core\Supports;

/**
 * Class Price
 *
 * @package Modules\Core\Supports\Price
 *
 * @method static string bcadd($left_operand, $right_operand, $scale = null)
 * @method static string bcsub($left_operand, $right_operand, $scale = null)
 * @method static string bcmul($left_operand, $right_operand, $scale = null)
 * @method static string bcdiv($left_operand, $right_operand, $scale = null)
 */
class Price
{
    public static function __callStatic($name, $arguments)
    {
        if (starts_with($name, 'bc')) {
            return call_user_func_array($name, array_map(function ($value) {
                return number_format($value, 2, '.', '');
            }, $arguments));
        }

        return self::__callStatic($name, $arguments);
    }
}
