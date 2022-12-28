<?php

namespace App\Http\Controllers;

use App\Service\BaristaService;
use Illuminate\Http\Request;

class BaristaProfileController extends BaseController
{
    public function __construct(protected BaristaService $service)
    {
        
    }
    
    public function get()
    {   
        return $this->sendResponse(
            $this->service->get()
        );
    }

    public function create(Request $request)
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    public function update(Request $request, $id)
    {
        return $this->sendResponse(
            $this->service->update($request, $id)
        );
    }

    public function delete($id)
    {
        return $this->sendResponse(
            $this->service->delete($id)
        );
    }
}
