<?php

/**
 * Home service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

/**
 * HomeService class
 * 
 * @method array get()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class HomeService extends BaseService
{
    /**
     * Get header for user role
     *
     * @return array
     */
    public function get() : array
    {
        $role = auth()->user()?->role->name;
        
        if (!$role) {
            $role = 'guest';
        }

        $this->data = [
            'header' => config("options.header.$role")
        ];

        return $this->sendResponse();
    }
}