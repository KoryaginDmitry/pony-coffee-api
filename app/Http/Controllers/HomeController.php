<?php

namespace App\Http\Controllers;

use App\Service\HomeService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{   
    public function __construct(protected HomeService $service)
    {
        
    }
    
    public function get()
    {
        return $this->sendResponse(
            $this->service->get()
        );
    }
}
