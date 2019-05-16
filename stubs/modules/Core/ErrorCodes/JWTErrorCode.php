<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2019-03-20
 * Time: 13:51
 */

namespace Modules\Core\ErrorCodes;


class JWTErrorCode
{
    const DEFAULT = 100;
    const INVALID_CLAIM = 101;
    const PAYLOAD = 102;
    const TOKEN_BLACKLISTED = 103;
    const TOKEN_EXPIRED = 104;
    const CAN_NOT_REFRESHED = 105;
    const TOKEN_INVALID = 106;
    const USER_NOT_DEFINED = 107;
}
