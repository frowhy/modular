<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/12/18
 * Time: 下午12:15
 */

namespace Modules\Core\Supports;

use Carbon\Carbon;

class IdentificationCard
{
    //验证身份证是否有效
    public static function validateIDCard(string $idCard): bool
    {
        if (18 === strlen($idCard)) {
            return self::check18IDCard($idCard);
        } elseif ((15 === strlen($idCard))) {
            $idCard = self::convertIDCard15to18($idCard);

            return self::check18IDCard($idCard);
        } else {
            return false;
        }
    }

    //计算身份证的最后一位验证码,根据国家标准GB 11643-1999
    private static function calcIDCardCode(string $idCard): string
    {
        if (17 !== strlen($idCard)) {
            return false;
        }

        //加权因子
        $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        //校验码对应值
        $code = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
        $checksum = 0;

        for (
            $i = 0;
            $i < strlen($idCard);
            $i++
        ) {
            $checksum += substr($idCard, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

    // 将15位身份证升级到18位
    private static function convertIDCard15to18(string $idCard): string
    {
        if (15 !== strlen($idCard)) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($idCard, 12, 3), ['996', '997', '998', '999']) !== false) {
                $idCard = substr($idCard, 0, 6).'18'.substr($idCard, 6, 9);
            } else {
                $idCard = substr($idCard, 0, 6).'19'.substr($idCard, 6, 9);
            }
        }
        $idCard = $idCard.self::calcIDCardCode($idCard);

        return $idCard;
    }

    // 18位身份证校验码有效性检查
    private static function check18IDCard(string $idCard): bool
    {
        if (18 !== strlen($idCard)) {
            return false;
        }

        $idCardBody = substr($idCard, 0, 17); //身份证主体
        $idCardCode = strtoupper(substr($idCard, 17, 1)); //身份证最后一位的验证码

        if (self::calcIDCardCode($idCardBody) !== $idCardCode) {
            return false;
        } else {
            return true;
        }
    }

    public static function getAge($idCard): int
    {
        $birthday =
            strlen($idCard) === 15 ? ('19'.substr($idCard, 6, 6))
                : substr($idCard, 6, 8);

        return Carbon::parse($birthday)->diffInYears(Carbon::today());
    }

    public static function getGender($idCard): int
    {
        return substr($idCard, (strlen($idCard) === 15 ? -2 : -1), 1) % 2 ? 2 : 1;
    }
}
