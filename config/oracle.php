<?php

return [
    'aral' => [
        'driver'         => 'oracle',
        'host'           => env('ARAL_DB_HOST'), //aral-prd-db
        'port'           => env('ARAL_DB_PORT'),
        'database'       => env('ARAL_DB_DATABASE'),
        'service_name'   => env('ARAL_DB_SERVICE_NAME'),
        'username'       => env('ARAL_DB_USERNAME'),
        'password'       => env('ARAL_DB_PASSWORD'),
        'charset'        => env('ARAL_DB_CHARSET'),
        'prefix'         => env('ARAL_DB_PREFIX'),
        'prefix_schema'  => env('ARAL_DB_SCHEMA_PREFIX'),
        'edition'        => env('ARAL_DB_EDITION'),
        'server_version' => env('ARAL_DB_SERVER_VERSION'),
    ],
    
    'ecommerce' => [
        'driver'         => 'oracle',
        'host'           => env('ECOM_DB_HOST'),
        'port'           => env('ECOM_DB_PORT'),
        'database'       => env('ECOM_DB_DATABASE'),
        'service_name'   => env('ECOM_DB_SERVICE_NAME'),
        'username'       => env('ECOM_DB_USERNAME'),
        'password'       => env('ECOM_DB_PASSWORD'),
        'charset'        => env('ECOM_DB_CHARSET', 'CL8MSWIN1251'),
        'prefix'         => env('ECOM_DB_PREFIX'),
        'prefix_schema'  => env('ECOM_DB_SCHEMA_PREFIX'),
        'edition'        => env('ECOM_DB_EDITION'),
        'server_version' => env('ECOM_DB_SERVER_VERSION'),
    ],
    
    'lara_qua' => [
        'driver'         => 'oracle',
        'host'           => env('LARA_QUA_DB_HOST'),
        'port'           => env('LARA_QUA_DB_PORT'),
        'database'       => env('LARA_QUA_DB_DATABASE'),
        'service_name'   => env('LARA_QUA_DB_SERVICE_NAME'),
        'username'       => env('LARA_QUA_DB_USERNAME'),
        'password'       => env('LARA_QUA_DB_PASSWORD'),
        'charset'        => env('LARA_QUA_DB_CHARSET'),
        'prefix'         => env('LARA_QUA_DB_PREFIX'),
        'prefix_schema'  => env('LARA_QUA_DB_SCHEMA_PREFIX'),
        'edition'        => env('LARA_QUA_DB_EDITION'),
        'server_version' => env('LARA_QUA_DB_SERVER_VERSION'),
    ],
];
