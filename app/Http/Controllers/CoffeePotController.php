<?php
/**
 * CoffeePotController class
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

use App\Service\CoffeePotService;
use Illuminate\Http\Request;

/**
 * CoffeePotController class
 * 
 * @method array getAddressCoffeePots()
 * @method array getCoffeePots()
 * @method array create()
 * @method array update()
 * @method array delete()
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
class CoffeePotController extends BaseController
{
    /**
     * Method connection service class
     *
     * @param CoffeePotService $service param service class
     */
    public function __construct(protected CoffeePotService $service)
    {
        
    }

    /**
     * Method get address coffee pots
     *
     * @return array
     */
    public function getAddressCoffeePots() : array
    {
        return $this->sendResponse(
            $this->service->getAddressCoffeePots()
        );
    }

    /**
     * Method get coffee pots
     *
     * @return array
     */
    public function getCoffeePots() : array
    {
        return $this->sendResponse(
            $this->service->getCoffeePots()
        );
    }

    /**
     * Method create coffee pot
     *
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function create(Request $request) : array
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Method update coffee pot
     *
     * @param int     $id      id coffee pot
     * @param Request $request object Request class
     * 
     * @return array
     */
    public function update(int $id, Request $request) : array
    {   
        return $this->sendResponse(
            $this->service->update($id, $request)
        );
    }

    /**
     * Method delete coffee pot
     *
     * @param int $id id coffee pot
     * 
     * @return array
     */
    public function delete(int $id) : array
    {
        return $this->sendResponse(
            $this->service->delete($id)
        );
    }
}
