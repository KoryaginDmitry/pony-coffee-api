<?php
/**
 * Auth controller
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

use App\Service\AuthService;
use Illuminate\Http\Request;

/**
 * AuthController class
 * 
 * @method array login()
 * @method array register()
 * @method array logout()
 * @method array login()
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
class AuthController extends BaseController
{
    /**
     * Server connection
     *
     * @param AuthService $service comment connection service class
     */
    public function __construct(protected AuthService $service)
    {
        
    }

    /**
     * Login
     *
     * @param Request $request comment Request class odject
     * 
     * @return array
     */
    public function login(Request $request)
    {   
        return $this->sendResponse(
            $this->service->login($request)
        );
    }

    /**
     * Register
     *
     * @param Request $request comment Request class odject
     * 
     * @return array
     */
    public function register(Request $request)
    {
        return $this->sendResponse(
            $this->service->register($request)
        );
    }

    /**
     * Logoout
     *
     * @return array
     */
    public function logout()
    {
        return $this->sendResponse(
            $this->service->logout()
        );
    }
}
