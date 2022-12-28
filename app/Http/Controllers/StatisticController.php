<?php

namespace App\Http\Controllers;

use App\Service\StatisticService;

class StatisticController extends BaseController
{
    public function __construct(protected StatisticService $service)
    {
        
    }
    
    public function barista()
    {
        return $this->sendResponse(
            $this->service->barista()
        );
    }

    public function user()
    {
        return $this->sendResponse(
            $this->service->user()
        );
    }
}
