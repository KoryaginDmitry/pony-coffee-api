<?php

/**
 * Profile controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Http\Controllers;

use App\Service\ProfileService;
use Illuminate\Http\Request;

/**
 * NotificationController class
 * 
 * @method array getUser()
 * @method array update()
 * @method array newPassword()
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class ProfileController extends BaseController
{
    /**
     * Construct method
     * 
     * Connection service class
     *
     * @param ProfileService $service param service class
     */
    public function __construct(protected ProfileService $service)
    {
        
    }

    /**
     * Get auth user
     *
     * @return array
     */
    public function getUser() : array
    {   
        return $this->sendResponse(
            $this->service->user()
        );
    }

    /**
     * Update auth user
     *
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function update(Request $request) : array
    {   
        return $this->sendResponse(
            $this->service->update($request)
        );
    }

    /**
     * New password for auth user
     *
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function newPassword(Request $request) : array
    {
        return $this->sendResponse(
            $this->service->newPassword($request)
        );
    }
}
