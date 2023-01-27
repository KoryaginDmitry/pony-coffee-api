<?php

/**
 * Array of parameters for the site
 */
return [
    /**
     * Regular expression for phone number validation
     */
    "phone_regex" => "\+7\d{10}",

    /**
     * Asrray with data for the site header
     */
    "header" => [
        "user" => [
            ['href' => '/', 'text' => 'Главная страница'],
            ['href' => '/profile', 'text' => 'Профиль'],
            ['href' => '/notifications', 'text' => 'Уведомления'],
            ['href' => '/feedback', 'text' => 'Обратная связь'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "barista" => [
            ['href' => '/user', 'text' => 'Создать пользователя'],
            ['href' => '/', 'text' => 'Главная страница'],
            ['href' => '/bonuses', 'text' => 'Бонусы'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "admin" => [
            ['href' => '/', 'text' => 'Главная страница'],
            ['href' => '/statistic/barista', 'text' => 'Статистика сотрудников'],
            ['href' => '/statistic/user', 'text' => 'Статистика гостей'],
            ['href' => '/feedback', 'text' => 'Обратная связь'],
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

    /**
     * Unique telegram channel id
     */
    'channel_id' => env('TELEGRAM_CHANEL_ID'),
    
    /**
     * Unique telegram bot token
     */
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    /**
     * Unique identifier for sending SMS
     */
    'sms_api_id' => env('SMS_API_ID')
];