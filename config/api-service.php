<?php

return [
    'navigation'                       => [
        'token' => [
            'cluster' => null,
            'group'   => 'User Token',
            'sort'    => -1,
            'icon'    => 'heroicon-o-key',
        ],
    ],
    'models'                           => [
        'token' => [
            'enable_policy' => false,
        ],
    ],
    'route'                            => [
        'panel_prefix'             => true,
        'use_resource_middlewares' => false,
    ],
    'tenancy'                          => [
        'enabled'   => true,
        'awareness' => false,
    ],
    'login-rules'                      => [
        'email'    => 'required|email',
        'password' => 'required',
    ],
    'use-spatie-permission-middleware' => true,
];
