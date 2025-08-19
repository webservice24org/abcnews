<?php


use LakM\CommentsAdminPanel\Middleware\AdminPanelAccessMiddleware;

return [
    'enabled' => true,
    'routes' => [
        'middlewares' => [
            'web',
            AdminPanelAccessMiddleware::class,
        ],
        'prefix' => 'admin',
    ],

    'commentable_models' => [],
];