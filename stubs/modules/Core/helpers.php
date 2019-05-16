<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/11/26
 * Time: 下午2:45
 */

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Core\Supports\Response;

/**
 * 生成验证码
 */
if (!function_exists('verification_code')) {
    function verification_code(int $length = 4, string $type = 'int'): string
    {
        if ('int' === $type) {
            return sprintf("%0{$length}d", rand(0, pow(10, $length) - 1));
        } else {
            return Str::random($length);
        }
    }
}

/**
 * 相对 URL
 */
if (!function_exists('relative_url')) {
    function relative_url(?string $url = null): ?string
    {
        return $url === null
            ? $url
            : (false === Str::start($url, 'http://') ? (false === Str::start($url, 'https://')
                ? $url : Str::replaceFirst('https://', '//', $url)) : Str::replaceFirst('http://', '//', $url));
    }
}

/**
 * 储存 URL
 */
if (!function_exists('storage_url')) {
    function storage_url(?string $url = null): ?string
    {
        return $url === null ? $url : (starts_with($url, 'http') ? $url : Storage::url($url));
    }
}

/**
 * 两位小数
 */
if (!function_exists('price')) {
    function price(float $price): string
    {
        return number_format($price, 2);
    }
}

/**
 * 16 进制转 RGB
 */
if (!function_exists('hex2rgb')) {
    function hex2rgb(string $hexColor): array
    {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb = [
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2)),
            ];
        } else {
            $color = $hexColor;
            $r = substr($color, 0, 1).substr($color, 0, 1);
            $g = substr($color, 1, 1).substr($color, 1, 1);
            $b = substr($color, 2, 1).substr($color, 2, 1);
            $rgb = [
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b),
            ];
        }

        return $rgb;
    }
}

/**
 * 灰度等级
 */
if (!function_exists('gray_level')) {
    function gray_level(array $rgb): float
    {
        return $rgb['r'] * 0.299 + $rgb['g'] * 0.587 + $rgb['b'] * 0.114;
    }
}

/**
 * 去年时间范围
 */
if (!function_exists('last_year')) {
    function last_year(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->subYear()->startOfYear();
        $end_at = $carbon->today()->subYear()->endOfYear();

        return compact('start_at', 'end_at');
    }
}

/**
 * 今年时间范围
 */
if (!function_exists('this_year')) {
    function this_year(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->startOfYear();
        $end_at = $carbon->today()->endOfYear();

        return compact('start_at', 'end_at');
    }
}

/**
 * 明年时间范围
 */
if (!function_exists('next_year')) {
    function next_year(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->addYear()->startOfYear();
        $end_at = $carbon->today()->addYear()->endOfYear();

        return compact('start_at', 'end_at');
    }
}

/**
 * 上个月时间范围
 */
if (!function_exists('last_month')) {
    function last_month(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->subMonth()->startOfMonth();
        $end_at = $carbon->today()->subMonth()->endOfMonth();

        return compact('start_at', 'end_at');
    }
}

/**
 * 本月时间范围
 */
if (!function_exists('this_month')) {
    function this_month(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->startOfMonth();
        $end_at = $carbon->today()->endOfMonth();

        return compact('start_at', 'end_at');
    }
}

/**
 * 下个月时间范围
 */
if (!function_exists('next_month')) {
    function next_month(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->addMonth()->startOfMonth();
        $end_at = $carbon->today()->addMonth()->endOfMonth();

        return compact('start_at', 'end_at');
    }
}

/**
 * 上周时间范围
 */
if (!function_exists('last_week')) {
    function last_week(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->subWeek()->startOfWeek();
        $end_at = $carbon->today()->subWeek()->endOfWeek();

        return compact('start_at', 'end_at');
    }
}

/**
 * 本周时间范围
 */
if (!function_exists('this_week')) {
    function this_week(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->startOfWeek();
        $end_at = $carbon->today()->endOfWeek();

        return compact('start_at', 'end_at');
    }
}

/**
 * 下周时间范围
 */
if (!function_exists('next_week')) {
    function next_week(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->addWeek()->startOfWeek();
        $end_at = $carbon->today()->addWeek()->endOfWeek();

        return compact('start_at', 'end_at');
    }
}

/**
 * 昨天时间范围
 */
if (!function_exists('yesterday')) {
    function yesterday(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->yesterday()->startOfDay();
        $end_at = $carbon->yesterday()->startOfDay();

        return compact('start_at', 'end_at');
    }
}

/**
 * 今天时间范围
 */
if (!function_exists('today')) {
    function today(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->today()->startOfDay();
        $end_at = $carbon->today()->startOfDay();

        return compact('start_at', 'end_at');
    }
}

/**
 * 明天时间范围
 */
if (!function_exists('tomorrow')) {
    function tomorrow(): array
    {
        $carbon = new Carbon();
        $start_at = $carbon->tomorrow()->startOfDay();
        $end_at = $carbon->tomorrow()->startOfDay();

        return compact('start_at', 'end_at');
    }
}

/**
 * 微信浏览器
 */
if (!function_exists('in_wechat')) {
    function in_wechat(): bool
    {
        return Str::contains(request(), 'MicroMessenger');
    }
}

/**
 * 微信
 */
if (!function_exists('is_wechat')) {
    function is_wechat(): bool
    {
        return in_wechat() && !is_mini_program();
    }
}

/**
 * 小程序
 */
if (!function_exists('is_mini_program')) {
    function is_mini_program(): bool
    {
        return in_wechat() && request()->get('is_mini_program', false);
    }
}

/**
 * 读取 DATA 数据
 */
if (!function_exists('get_data')) {
    function get_data($data, $index = null, $key = null)
    {
        if ($data instanceof Collection || $data instanceof Response) {
            $data = $data->toArray();
        }

        if (Arr::has($data, 'data')) {
            $field = 'data.';
        } else {
            $field = '';
        }

        if (Arr::has($data, "{$field}0") && !Arr::has($data, "{$field}1")) {
            if (!is_null($index) && is_int($index)) {
                $key = "{$index}.{$key}";
            } else {
                if (!is_null($index)) {
                    $key = "0.{$index}";
                } else {
                    $key = 0;
                }
            }
        } else {
            if (is_null($index)) {
                $key = null;
            } else {
                $key = $index;
            }
        }
        if ($key === null) {
            $key = '';
        }

        $key = rtrim("{$field}{$key}", '.');

        if ($key) {
            return Arr::get($data, $key);
        }

        return $data;
    }
}

/**
 * 清空缓存
 */
if (!function_exists('clear_cache')) {
    function clear_cache(): void
    {
        if (config('cache.opcache_enabled')) {
            $opcache = app('Appstract\Opcache\OpcacheFacade');
            if (false !== $opcache::getStatus()) {
                $opcache::clear();
            }
        }
        Cache::tags('website')->flush();
    }
}

/**
 * 判定缓存
 */
if (!function_exists('has_cache')) {
    function has_cache(string $uri): bool
    {
        return Cache::tags('website')->has($uri);
    }
}

/**
 * 读取缓存
 */
if (!function_exists('get_cache')) {
    function get_cache(string $uri)
    {
        return Cache::tags('website')->get($uri);
    }
}

/**
 * 写缓存
 */
if (!function_exists('set_cache')) {
    function set_cache(string $uri, string $response): void
    {
        Cache::tags('website')->put($uri, $response, config('cache.timeout'));
    }
}

/**
 * 随机值
 */
if (!function_exists('random')) {
    function random(int $length = 4, string $type = 'digital'): string
    {
        if ('digital' === $type) {
            return random_digital($length);
        } elseif ('alphabet' === $type) {
            return random_alphabet($length);
        } else {
            return Str::random($length);
        }
    }
}

/**
 * 随机数字
 */
if (!function_exists('random_digital')) {
    function random_digital(int $length = 4): string
    {
        return sprintf("%0{$length}d", rand(0, pow(10, $length) - 1));
    }
}

/**
 * 随机字母
 */
if (!function_exists('random_alphabet')) {
    function random_alphabet(int $length = 4): string
    {
        $str = '';
        $map = [
            ['65', '90'],
            ['97', '122'],
        ];
        for ($i = 0; $i < $length; $i++) {
            $param = Arr::random($map);
            $str .= chr(call_user_func_array('rand', $param));
        }
        return $str;
    }
}

/**
 * 随机大写字母
 */
if (!function_exists('random_alphabet_upper')) {
    function random_alphabet_upper(int $length = 4): string
    {
        return strtoupper(random_alphabet($length));
    }
}

/**
 * 随机小写字母
 */
if (!function_exists('random_alphabet_lower')) {
    function random_alphabet_lower(int $length = 4): string
    {
        return strtolower(random_alphabet($length));
    }
}

/**
 * 随机日期
 */
if (!function_exists('random_date')) {
    function random_date(): string
    {
        return mt_rand(2000, date('Y')).sprintf("%02d", mt_rand(1, 12)).sprintf("%02d", mt_rand(1, 28));
    }
}

/**
 * 轮询调度
 */
if (!function_exists('round_robin')) {
    function round_robin(array &$items, array &$result): void
    {
        $total = 0;
        $best = null;

        foreach ($items as $key => $item) {
            $current = &$items[$key];
            $weight = $current['weight'];

            $current['current_weight'] += $weight;
            $total += $weight;

            if (($best == null) || ($items[$best]['current_weight'] <
                                    $current['current_weight'])) {
                $best = $key;
            }
        }

        $items[$best]['current_weight'] -= $total;
        $items[$best]['count']++;

        $result[] = $best;
    }
}

/**
 * 13 位时间戳
 *
 * @return float
 */
if (!function_exists('get_millisecond')) {
    function get_millisecond(): float
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}

/**
 * Ascii Code Encode
 *
 * @return float
 */
if (!function_exists('ascii_encode')) {
    function ascii_encode(string $string): ?string
    {
        $length = strlen($string);
        $a = 0;
        $ascii = null;
        while ($a < $length) {
            $ud = 0;
            if (ord($string{$a}) >= 0 && ord($string{$a}) <= 127) {
                $ud = ord($string{$a});
                $a += 1;
            } elseif (ord($string{$a}) >= 192 && ord($string{$a}) <= 223) {
                $ud = (ord($string{$a}) - 192) * 64 + (ord($string{$a + 1}) - 128);
                $a += 2;
            } elseif (ord($string{$a}) >= 224 && ord($string{$a}) <= 239) {
                $ud =
                    (ord($string{$a}) - 224) * 4096 + (ord($string{$a + 1}) - 128) * 64 + (ord($string{$a + 2}) - 128);
                $a += 3;
            } elseif (ord($string{$a}) >= 240 && ord($string{$a}) <= 247) {
                $ud =
                    (ord($string{$a}) - 240) * 262144 +
                    (ord($string{$a + 1}) - 128) * 4096 +
                    (ord($string{$a + 2}) - 128) * 64 +
                    (ord($string{$a + 3}) - 128);
                $a += 4;
            } elseif (ord($string{$a}) >= 248 && ord($string{$a}) <= 251) {
                $ud =
                    (ord($string{$a}) - 248) * 16777216 +
                    (ord($string{$a + 1}) - 128) * 262144 +
                    (ord($string{$a + 2}) - 128) * 4096 +
                    (ord($string{$a + 3}) - 128) * 64 +
                    (ord($string{$a + 4}) - 128);
                $a += 5;
            } elseif (ord($string{$a}) >= 252 && ord($string{$a}) <= 253) {
                $ud =
                    (ord($string{$a}) - 252) * 1073741824 +
                    (ord($string{$a + 1}) - 128) * 16777216 +
                    (ord($string{$a + 2}) - 128) * 262144 +
                    (ord($string{$a + 3}) - 128) * 4096 +
                    (ord($string{$a + 4}) - 128) * 64 +
                    (ord($string{$a + 5}) - 128);
                $a += 6;
            } elseif (ord($string{$a}) >= 254 && ord($string{$a}) <= 255) {
                $ud = false;
            }
            $ascii .= "&#$ud;";
        }
        return $ascii;
    }
}

/**
 * Get the boolean value of a variable
 */
if (!function_exists('is_true')) {
    function is_true($val): bool
    {
        return $val instanceof \Modules\Core\Contracts\Support\Boolable
            ? $val->toBool()
            : (is_string($val)
                ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : boolval($val));
    }
}

if (!function_exists('get_routes')) {
    function get_routes($module = null): Collection
    {
        /** @var \Illuminate\Support\Collection $routes */
        $routes = collect(Route::getRoutes()->getRoutesByName())->groupBy(function ($item, $key) {
            $keys = explode('.', $key);

            return $keys[0];
        }, true)->map(function (Collection $item) {
            return $item->mapWithKeys(function ($item, $key) {
                $keys = explode('.', $key);
                $route = collect($item->action)
                    ->put('method', $item->methods[0])
                    ->put('uri', $item->uri)
                    ->forget('uses')
                    ->sort();

                return [implode('.', Arr::except($keys, 0)) => $route];
            })->sortKeys();
        })->sortKeys();

        if (null !== $module) {
            return $routes->get($module) ?? collect();
        }

        return $routes;
    }
}
