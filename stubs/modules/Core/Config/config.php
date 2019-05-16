<?php

return [
    'name' => 'Core',

    'api' => [
        /*
        |--------------------------------------------------------------------------
        | Default API Version
        |--------------------------------------------------------------------------
        |
        | This is the default version when strict mode is disabled and your API
        | is accessed via a web browser. It's also used as the default version
        | when generating your APIs documentation.
        |
        */

        'version' => env('API_VERSION', 'v1'),

        /*
        |--------------------------------------------------------------------------
        | Generic Error Format
        |--------------------------------------------------------------------------
        |
        | When some HTTP exceptions are not caught and dealt with the API will
        | generate a generic error response in the format provided. Any
        | keys that aren't replaced with corresponding values will be
        | removed from the final response.
        |
        */

        'error_format' => env('ERROR_FORMAT', 'api'),

        /*
        |--------------------------------------------------------------------------
        | Generic Output Format
        |--------------------------------------------------------------------------
        |
        | When some HTTP exceptions are not caught and dealt with the API will
        | generate a generic error response in the format provided. Any
        | keys that aren't replaced with corresponding values will be
        | removed from the final response.
        |
        */

        'output_format' => env('OUTPUT_FORMAT', 'json'),

        'status_sync' => env('STATUS_SYNC', true),

        'cors_enabled' => env('CORS_ENABLED', false),
    ],
];
