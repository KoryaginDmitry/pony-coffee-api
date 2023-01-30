<?php

/**
 * SiteData service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Models\Bonus;

/**
 * SiteDataService class
 * 
 * @method JsonResponse header()
 * @method JsonResponse bonusLifetime()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SiteDataService extends BaseService
{
    /**
     * Get header for role user
     *
     * @return array
     */
    public function header() : array
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

    /**
     * Get bonus lifetime
     *
     * @return array
     */
    public function bonusLifetime() : array
    {
        $this->data = [
            'lifetime' => Bonus::getLifetime()
        ];

        return $this->sendResponse();
    }
}