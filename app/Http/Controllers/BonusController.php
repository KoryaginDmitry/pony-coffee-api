<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\BonusService;

class BonusController extends BaseController
{   
    public function __construct(protected BonusService $service)
    {
        
    }
    
    public function getInfoBonuses()
    {
        return $this->sendResponse(
            $this->service->getInfoBonuses()
        );
    }

    public function search(Request $request)
    {
        return $this->sendResponse(
            $this->service->search($request)
        );
    }

    public function create($id)
    {
        return $this->sendResponse(
            $this->service->create($id)
        );
    }

    public function wrote($id)
    {
        return $this->sendResponse(
            $this->service->wrote($id)
        );
    }
}
