<?php

namespace Modules\Core\Supports;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Modules\Core\Enums\StatusCodeEnum;
use Modules\Core\ErrorCodes\JWTErrorCode;
use Symfony\Component\HttpKernel\Exception\{
    HttpException, UnauthorizedHttpException
};
use Tymon\JWTAuth\Exceptions\{
    InvalidClaimException,
    JWTException,
    PayloadException,
    TokenBlacklistedException,
    TokenExpiredException,
    TokenInvalidException,
    UserNotDefinedException
};

class Handler extends ExceptionHandler
{
    const STATUS_CODE = 'status_code';
    const ERROR_CODE = 'error_code';
    const MESSAGE = 'message';
    const DEBUG = 'debug';

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception|HttpException $exception
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            if ('web' !== config('core.api.error_format')) {
                if ($exception instanceof UnauthorizedHttpException) {
                    $exception = method_exists($exception, 'getPrevious') ? $exception->getPrevious() : $exception;
                }
                if ($exception instanceof ModelNotFoundException) {
                    $response['meta'][self::STATUS_CODE] = StatusCodeEnum::HTTP_NOT_FOUND;
                    $response['meta'][self::MESSAGE] = $exception->getMessage();
                } elseif ($exception instanceof JWTException) {
                    if ($exception instanceof InvalidClaimException) {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::INVALID_CLAIM;
                    } elseif ($exception instanceof PayloadException) {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::PAYLOAD;
                    } elseif ($exception instanceof TokenBlacklistedException) {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::TOKEN_BLACKLISTED;
                    } elseif ($exception instanceof TokenExpiredException) {
                        if ('Token has expired and can no longer be refreshed' === $exception->getMessage()) {
                            $response['meta'][self::ERROR_CODE] = JWTErrorCode::CAN_NOT_REFRESHED;
                        } else {
                            $response['meta'][self::ERROR_CODE] = JWTErrorCode::TOKEN_EXPIRED;
                        }
                    } elseif ($exception instanceof TokenInvalidException) {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::TOKEN_INVALID;
                    } elseif ($exception instanceof UserNotDefinedException) {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::USER_NOT_DEFINED;
                    } else {
                        $response['meta'][self::ERROR_CODE] = JWTErrorCode::DEFAULT;;
                    }
                    $response['meta'][self::STATUS_CODE] = StatusCodeEnum::HTTP_UNAUTHORIZED;
                    $response['meta'][self::MESSAGE] = $exception->getMessage();
                } else {
                    $response['meta'][self::STATUS_CODE] =
                        method_exists($exception, 'getStatusCode') ? $exception->getStatusCode()
                            : StatusCodeEnum::HTTP_INTERNAL_SERVER_ERROR;
                    if ($exception->getCode()) {
                        $response['meta'][self::ERROR_CODE] = $exception->getCode();
                    }
                    $response['meta'][self::MESSAGE] =
                        null === $exception->getMessage() ? class_basename(get_class($exception))
                            : $exception->getMessage();
                }
                if (true === config('app.debug')) {
                    $response['meta'][self::DEBUG]['file'] = $exception->getFile();
                    $response['meta'][self::DEBUG]['line'] = $exception->getLine();
                    $response['meta'][self::DEBUG]['trace'] = $exception->getTrace();
                }

                return $this->response(collect($response)->toArray());
            }
        }

        return parent::render($request, $exception);
    }

    protected function response(array $response)
    {
        return (new Response($response))->render();
    }
}
