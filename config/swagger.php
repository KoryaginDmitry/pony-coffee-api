<?php

use App\Actions\MakeTokenForSwaggerAction;

return [
    /*
     * Version OpenApi
     */
    'openapi' => '3.0.0',

    /*
     * Information
     */
    'info' => [
        'title' => 'API documentation',
        'description' => 'API documentation',
        'version' => '1.0.0',
        'termsOfService' => 'https://example.com/terms',
        'contact' => [
            'name' => 'example',
            'url' => 'https://example.com',
            'email' => 'example@mail.ru',
        ],
        'license' => [
            'name' => 'CC Attribution-ShareAlike 4.0 (CC BY-SA 4.0)',
            'url' => 'https://openweathermap.org/price',
        ],
    ],

    /*
     * authorization schemes
     */
    'securitySchemes' => [
        'passport' => [
            'type' => 'http',
            'in' => 'header',
            'name' => 'Authorization',
            'scheme' => 'Bearer',
            'description' => 'To authorize, use the key ',
        ],
        'sanctum' => [
            'type' => 'http',
            'in' => 'header',
            'name' => 'Authorization',
            'scheme' => 'Bearer',
            'description' => 'To authorize, use the key ',
        ],
    ],

    /*
     * Servers for executing requests
     */
    'servers' => [
        [
            'url' => env('APP_URL'),
            'description' => 'Server for testing',
        ],
    ],

    'auth' => [
        /*
         * Is there authorization
         */
        'has_auth' => true,

        /*
         * Software that checks authorization for a route
         */
        'middleware' => 'auth',

        /*
         * Authorization scheme
         */
        'security_schema' => 'passport',

        /*
         * Method for obtaining token(s) for authorization
         */
        'make_token' => [
            'action' => MakeTokenForSwaggerAction::class,
        ],
    ],

    /*
     * Information on storing data files after testing
     */
    'storage' => [
        'driver' => 'local',
        'path' => 'data',
    ],

    /*
     * First key that does not refer to resources
     */
    'pre_key' => 'data',

    'resources_keys' => [
        /*
         * Do resources have a key
         */
        'has_pre_key' => false,

        /*
         * Using the wrap property as a resource name
         */
        'use_wrap' => false,
    ],

    /*
     * Description of response codes
     */
    'codes' => [
        200 => 'Request completed successfully',
        201 => 'Object created successfully',
        204 => 'Not content',
        401 => 'Not authentication',
        403 => 'Not authorization',
        404 => 'Not found',
        422 => 'Data validation error',
        500 => 'Server error',
    ],
];
