<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/8/1
 * Time: 下午3:25
 */

namespace Modules\Core\Supports;

use Asm89\Stack\CorsService;
use Illuminate\Contracts\Support\{
    Arrayable, Renderable, Responsable
};
use Illuminate\Http\Response as BaseResponse;
use Illuminate\Support\{Arr, Str};
use Modules\Core\Contracts\Support\Boolable;
use Modules\Core\Enums\StatusCodeEnum;
use SoapBox\Formatter\Formatter;

class Response implements Responsable, Arrayable, Renderable, Boolable
{
    protected $response;
    protected $statusCode;

    public function __construct(array $response)
    {
        $this->response = $response;
        $this->statusCode = $response['meta']['status_code'] ?? StatusCodeEnum::HTTP_OK;

        return $this;
    }

    /**
     * 格式化响应
     *
     * @return \Illuminate\Http\Response
     */
    private function format(): BaseResponse
    {
        list($response, $statusCode) = [$this->response, $this->statusCode];
        $formatter = Formatter::make($response, Formatter::ARR);
        $format = self::param('output_format') ?? (config('core.api.output_format'));
        $statusCode =
            (self::param('status_sync') ?? config('core.api.status_sync')) ? $statusCode : StatusCodeEnum::HTTP_OK;
        if (in_array($format, ['application/xml', 'xml'])) {
            $response = response($formatter->toXml(), $statusCode, ['Content-Type' => 'application/xml']);
        } elseif (in_array($format, ['application/x-yaml', 'yaml'])) {
            $response = response($formatter->toYaml(), $statusCode, ['Content-Type' => 'application/x-yaml']);
        } elseif (in_array($format, ['text/csv', 'csv'])) {
            $response = response($formatter->toCsv(), $statusCode, ['Content-Type' => 'text/csv']);
        } elseif (in_array($format, ['application/json', 'json'])) {
            $response = response($formatter->toJson(), $statusCode, ['Content-Type' => 'application/json']);
        } else {
            $response = response($response, $statusCode);
        }
        return $response;
    }

    /**
     * s
     * 允许跨域请求
     *
     * @param \Illuminate\Http\Response $response
     * @return \Illuminate\Http\Response
     */
    private function cors(BaseResponse $response): BaseResponse
    {
        if (config('core.api.cors_enabled')) {
            /** @var CorsService $cors */
            $cors = app(CorsService::class);
            $request = request();

            if ($cors->isCorsRequest(request())) {
                if (!$response->headers->has('Access-Control-Allow-Origin')) {
                    $response = $cors->addActualRequestHeaders($response, $request);
                }
            }
        }

        return $response;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request): BaseResponse
    {
        return $this->render();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return (array) Arr::get($this->response, 'data');
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return \Illuminate\Http\Response
     */
    public function render(): BaseResponse
    {
        return $this->cors($this->format());
    }

    /**
     * Get the true and false of the instance.
     *
     * @return bool
     */
    public function toBool(): bool
    {
        return Str::startsWith(Arr::get($this->response, 'meta.status_code'), 2);
    }

    public static function param(string $param): ?string
    {
        $request = app('Illuminate\Http\Request');
        if ($request->has($param)) {
            return $request->get($param);
        } else {
            $header_param = Str::title(Str::kebab(Str::studly($param)));
            if ($request->hasHeader($header_param)) {
                return $request->header($header_param);
            }
        }

        return null;
    }

    /**
     * Return an response.
     *
     * @param array $response
     *
     * @return Response
     */
    private static function call(array $response): Response
    {
        return new self($response);
    }

    /**
     * Response Handle
     *
     * @param int $statusCode
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handle(int $statusCode, $data = null, bool $overwrite = false, string $message = null): Response
    {
        if (($overwrite && is_array($data))) {
            $_data = $data;
        } elseif (is_array($data) && Arr::has($data, 'data')) {
            $_data = Arr::get($data, 'data');
        } else {
            if (is_string($data) && json_decode($data)) {
                $_data = json_decode($data);
            } else {
                $_data = $data;
            }
        }
        if ((is_array($data) && array_has($data, 'meta'))) {
            $_meta = array_get($data, 'meta');
        } else {
            $_meta = [];
        }
        $_meta = Arr::prepend($_meta, $statusCode, 'status_code');
        $_meta = Arr::prepend($_meta, $message ?? StatusCodeEnum::__($statusCode), 'message');
        Arr::set($response, 'meta', $_meta);
        if (!is_null($_data)) {
            Arr::set($response, 'data', $_data);
        }

        return self::call($response);
    }

    /**
     * Response Ok
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleOk($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_OK, $data, $overwrite, $message);
    }

    /**
     * Response Created
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleCreated($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_CREATED, $data, $overwrite, $message);
    }

    /**
     * Response Accepted
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleAccepted($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_ACCEPTED, $data, $overwrite, $message);
    }

    /**
     * Response NoContent
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleNoContent($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_NO_CONTENT, $data, $overwrite, $message);
    }

    /**
     * Response ResetContent
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleResetContent($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_RESET_CONTENT, $data, $overwrite, $message);
    }

    /**
     * Response SeeOther
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleSeeOther($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_SEE_OTHER, $data, $overwrite, $message);
    }

    /**
     * Response BadRequest
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleBadRequest($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_BAD_REQUEST, $data, $overwrite, $message);
    }

    /**
     * Response Unauthorized
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleUnauthorized($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_UNAUTHORIZED, $data, $overwrite, $message);
    }

    /**
     * Response PaymentRequired
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handlePaymentRequired($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_PAYMENT_REQUIRED, $data, $overwrite, $message);
    }

    /**
     * Response Forbidden
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleForbidden($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_PAYMENT_REQUIRED, $data, $overwrite, $message);
    }

    /**
     * Response NotFound
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleNotFound($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_NOT_FOUND, $data, $overwrite, $message);
    }

    /**
     * Response UnprocessableEntity
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleUnprocessableEntity($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_UNPROCESSABLE_ENTITY, $data, $overwrite, $message);
    }

    /**
     * Response Locked
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleLocked($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_LOCKED, $data, $overwrite, $message);
    }

    /**
     * Response TooManyRequests
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleTooManyRequests($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_TOO_MANY_REQUESTS, $data, $overwrite, $message);
    }

    /**
     * Response InternalServerError
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleInternalServerError($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_INTERNAL_SERVER_ERROR, $data, $overwrite, $message);
    }

    /**
     * Response NotImplemented
     *
     * @param $data
     * @param bool $overwrite
     * @param string|null $message
     * @return \Modules\Core\Supports\Response
     */
    public static function handleNotImplemented($data = null, bool $overwrite = false, string $message = null): Response
    {
        return self::handle(StatusCodeEnum::HTTP_NOT_IMPLEMENTED, $data, $overwrite, $message);
    }
}