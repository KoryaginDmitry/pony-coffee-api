<?php

namespace App\Http\Controllers;

use App\Service\CoffeePotService;
use Illuminate\Http\Request;

class CoffeePotController extends Controller
{
    public function __construct(protected CoffeePotService $service)
    {
        
    }

    public function getAddressCoffeePots()
    {
        $data = $this->service->getAddressCoffeePots();
        
        return response()->json($data['body'], $data['code']);
    }

    public function getCoffeePots()
    {
        $data = $this->service->getAddressCoffeePots();
        
        return response()->json($data['body'], $data['code']);
    }

    public function create(Request $request)
    {
        $data = $this->service->getAddressCoffeePots($request);
        
        return response()->json($data['body'], $data['code']);
    }

    public function update($id, Request $request)
    {   
        $data = $this->service->getAddressCoffeePots($id, $request);
        
        return response()->json($data['body'], $data['code']);
    }

    public function delete($id)
    {
        $data = $this->service->getAddressCoffeePots($id);
        
        return response()->json($data['body'], $data['code']);
    }
}
