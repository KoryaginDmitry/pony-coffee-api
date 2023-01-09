<?php

/**
 * Statistic controller
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

use App\Service\StatisticService;

/**
 * StatisticController class
 * 
 * @method array barista()
 * @method array user()
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
class StatisticController extends BaseController
{
    /**
     * Construct
     * 
     * Connection servcie class
     *
     * @param StatisticService $service param servcie class
     */
    public function __construct(protected StatisticService $service)
    {
        
    }
    
    /**
     * Barista
     * 
     * Get statistic baristas
     *
     * @return array
     */
    public function barista() : array
    {
        return $this->sendResponse(
            $this->service->barista()
        );
    }

    /**
     * User
     * 
     * Get statistic users
     *
     * @return array
     */
    public function user() : array
    {
        return $this->sendResponse(
            $this->service->user()
        );
    }
}
