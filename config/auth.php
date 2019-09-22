<?php

return [

    'defaults' => [
        'guard' => 'frontend',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'frontend' => [
            'driver' => 'jwt',
            'provider' => 'affiliate',
        ],

        'backend' => [
            'driver' => 'jwt',
            'provider' => 'admin',
        ],
    ],

    'providers' => [
        'affiliate' => [
            'driver' => 'eloquent',
            'model' => App\Models\Affiliate::class,
        ],

        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

    ],

];
