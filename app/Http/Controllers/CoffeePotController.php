<?php

namespace App\Http\Controllers;

use App\Service\CoffeePotService;
use Illuminate\Http\Request;

class CoffeePotController extends BaseController
{
    public function __construct(protected CoffeePotService $service)
    {
        
    }

    public function getAddressCoffeePots()
    {
        return $this->sendResponse(
            $this->service->getAddressCoffeePots()
        );
    }

    public function getCoffeePots()
    {
        return $this->sendResponse(
            $this->service->getCoffeePots()
        );
    }

    public function create(Request $request)
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    public function update($id, Request $request)
    {   
        return $this->sendResponse(
            $this->service->update($id, $request)
        );
    }

    public function delete($id)
    {
        return $this->sendResponse(
            $this->service->delete($id)
        );
    }
}
