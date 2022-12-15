<?php

namespace App\Http\Controllers;

use App\Service\StatisticService;

class StatisticController extends Controller
{
    public function __construct(protected StatisticService $service)
    {
        
    }
    public function barista()
    {
        return response()->json($this->service->barista, 200);
    }

    public function user()
    {
        return response()->json($this->service->user, 200);
    }
}
