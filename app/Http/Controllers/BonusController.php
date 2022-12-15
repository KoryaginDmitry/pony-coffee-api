<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\BonusService;

class BonusController extends Controller
{   
    public function __construct(protected BonusService $service)
    {
        
    }
    public function getInfoBonuses()
    {
        $data = $this->service->getInfoBonuses();

        return response()->json($data['body'], $data['code']);
    }

    public function search(Request $request)
    {
        $data = $this->service->search($request);

        return response()->json($data['body'], $data['code']);
    }

    public function create($id)
    {
        $data = $this->service->create($id);

        return response()->json($data['body'], $data['code']);
    }

    public function wrote($id)
    {
        $data = $this->service->wrote($id);

        return response()->json($data['body'], $data['code']);
    }
}
