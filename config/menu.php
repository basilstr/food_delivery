<?php
return [
    [
        'title' => 'Користувачі',
        'icon'  => 'fas fa-user-alt',
        'route' => '/user',
        'permission' => ['admin', 'master'],
    ],
    [
        'title' => 'Заклади',
        'icon'  => 'fas fa-hamburger',
        'route' => '/provider',
        'permission' => ['admin', 'master'],
    ],
    [
        'title' => 'Теги',
        'icon'  => 'fas fa-tags',
        'route' => '/tag',
        'permission' => ['admin'],
    ],
    [
        'title' => 'На модерації',
        'icon'  => 'fas fa-hourglass',
        'route' => '/moderation',
        'permission' => ['admin', 'master'],
    ],
    [
        'title' => 'Клієнти',
        'icon'  => 'fas fa-child',
        'route' => '/client',
        'permission' => ['admin', 'master'],
    ],
    [
        'title' => 'Кур\'єри',
        'icon'  => 'fas fa-motorcycle',
        'route' => '/courier',
        'permission' => ['admin', 'master'],
    ],
    /*[
        'title' => 'Menu 2',
        'icon'  => 'fas fa-tachometer-alt',
        'items' => [
            [
                'title' => 'sub menu 1',
                'icon' => 'fas fa-tachometer-alt',
                'route' => '/admin',
                'permission' => ['master'],
            ],
            [
                'title' => 'sub menu 2',
                'icon' => 'fas fa-tachometer-alt',
                'route' => '/admin',
            ],
        ],
    ],*/
];
