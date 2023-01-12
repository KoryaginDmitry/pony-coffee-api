<?php

/**
 * Home service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

/**
 * HomeService class
 * 
 * @method array get()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class HomeService extends BaseService
{
    /**
     * Array links header
     *
     * @var array
     */
    private array $_headers = [
        "user" => [
            ['href' => '/', 'text' => 'Главная страница'],
            ['href' => '/profile', 'text' => 'Профиль'],
            ['href' => '/notifications', 'text' => 'Уведомления'],
            ['href' => '/feedback', 'text' => 'Обратная связь'],
            ['href' => '/logout', 'text' => 'Выход'],
        ],
        "barista" => [
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
    ];

    /**
     * Get header for user role
     *
     * @return array
     */
    public function get() : array
    {
        if (auth()->check()) {
            $role = auth()->user()->role->name;
        } else {
            $role = 'guest';
        }

        $this->data = [
            'header' => $this->_headers[$role]
        ];

        return $this->sendResponse();
    }
}