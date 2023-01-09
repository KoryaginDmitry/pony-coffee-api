<?php
/**
 * Home controller
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

use App\Service\HomeService;
use Illuminate\Http\Request;

/**
 * HomeController class
 * 
 * @method array get()
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
class HomeController extends BaseController
{
    /**
     * Constuct method
     * 
     * Connection service class
     *
     * @param HomeService $service param service class
     */
    public function __construct(protected HomeService $service)
    {
        
    }
    
    /**
     * Get header for role user
     *
     * @return array
     */
    public function get() : array
    {
        return $this->sendResponse(
            $this->service->get()
        );
    }
}
