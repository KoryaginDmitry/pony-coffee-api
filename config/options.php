<?php

return [
    "header" => [
        "user" => [
            ['href' => '/', 'text' => 'Главная'],
            ['href' => '/profile', 'text' => 'Профиль'],
            ['href' => '/notifications', 'text' => 'Уведомления'],
            ['href' => '/feedback', 'text' => 'Обратная связь'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "barista" => [
            ['href' => '/', 'text' => 'Главная'],
            ['href' => '/user', 'text' => 'Создать пользователя'],
            ['href' => '/bonuses', 'text' => 'Бонусы'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "admin" => [
            ['href' => '/', 'text' => 'Главная'],
            ['href' => '/statistic/barista', 'text' => 'Статистика сотрудников'],
            ['href' => '/statistic/user', 'text' => 'Статистика гостей'],
            ['href' => '/feedback/admin', 'text' => 'Обратная связь'],
            ['href' => '/seending', 'text' => 'Рассылка'],
            ['href' => '/coffeePot', 'text' => 'Кофейни'],
            ['href' => '/barista', 'text' => 'Сотрудники'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "guest" => [
            ['href' => '/login', 'text' => 'Вход'],
            ['href' => '/register', 'text' => 'Регистрация'],
        ]
    ],

    'regex' => [
        'phone' => '\+7\d{10}',
    ],

    'bonus' => [
        'lifetime' => 30,
        'writeOffQuantity' => 3,
    ],

    'channels' => [
        'admin' => [
            [
                'event' => 'feedback',
                'path' => 'private-feedback.admin'
            ],
            [
                'event' => 'message',
                'path' => 'private-message.admin'
            ]
        ],
        'barista' => [

        ],
        'user' => [
            [
                'event' => 'message',
                'path' => 'private-message.user.{id}'
            ]
        ],
        'guest' => [

        ],
    ],
];
