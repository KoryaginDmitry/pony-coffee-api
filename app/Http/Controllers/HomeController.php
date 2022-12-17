<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $headers = [
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

    public function get()
    {
        if(auth('api')->check()){
            $role = auth('api')->user()->role->name;
        }
        else{
            $role = 'guest';
        }

        return response()->json($this->headers[$role], 200);
    }
}
