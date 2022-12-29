<?php

namespace App\Http\Controllers;

use App\Service\BaristaService;
use Illuminate\Http\Request;

/**
 * Barista controller class
 */
class BaristaProfileController extends BaseController
{
    /**
     * Undocumented function
     *
     * @param BaristaService $service
     */
    public function __construct(protected BaristaService $service)
    {
        
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function get()
    {   
        return $this->sendResponse(
            $this->service->getBaristas()
        );
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * 
     * @return array
     */
    public function create(Request $request)
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param int     $id
     * 
     * @return array
     */
    public function update(Request $request, $id)
    {
        return $this->sendResponse(
            $this->service->update($request, $id)
        );
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * 
     * @return array
     */
    public function delete($id)
    {
        return $this->sendResponse(
            $this->service->delete($id)
        );
    }
}
