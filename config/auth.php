<?php

return [

    /*
    |------------------------------------------------------------------
    | Defaults
    |------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins',
    ],

    /*
    |------------------------------------------------------------------
    | Guards
    |------------------------------------------------------------------
    */
    'guards' => [

        // ===== WEB (SESSION) =====
        'web' => [
            'driver' => 'session',
            'provider' => 'admins', // default web admin
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'penyelenggara' => [
            'driver' => 'session',
            'provider' => 'penyelenggaras',
        ],

        'pengunjung' => [
            'driver' => 'session',
            'provider' => 'pengunjungs',
        ],

        // ===== API (SANCTUM) =====
        'admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'admins',
        ],

        'penyelenggara-api' => [
            'driver' => 'sanctum',
            'provider' => 'penyelenggaras',
        ],

        'pengunjung-api' => [
            'driver' => 'sanctum',
            'provider' => 'pengunjungs',
        ],
    ],

    /*
    |------------------------------------------------------------------
    | Providers
    |------------------------------------------------------------------
    */
    'providers' => [

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'penyelenggaras' => [
            'driver' => 'eloquent',
            'model' => App\Models\Penyelenggara::class,
        ],

        'pengunjungs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pengunjung::class,
        ],
    ],

    /*
    |------------------------------------------------------------------
    | Password Reset
    |------------------------------------------------------------------
    */
    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
