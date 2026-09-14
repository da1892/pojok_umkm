<?php

return [
    'paths' => [
        resource_path('views'),
        resource_path('views/user'),
        resource_path('views/admin'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
