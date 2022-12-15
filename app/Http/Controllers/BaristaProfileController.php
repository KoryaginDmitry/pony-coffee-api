<?php

namespace App\Http\Controllers;

use App\Service\BaristaService;
use Illuminate\Http\Request;

class BaristaProfileController extends Controller
{
    public function __construct(protected BaristaService $service)
    {
        
    }
    
    public function get()
    {   
        $data = $this->service->get();

        return response()->json($data['body'], $data['code']);
    }

    public function create(Request $request)
    {
        $data = $this->service->create($request);

        return response()->json($data['body'], $data['code']);
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($request, $id);

        return response()->json($data['body'], $data['code']);
    }

    public function delete($id)
    {
        $data = $this->service->delete($id);

        return response()->json($data['body'], $data['code']);
    }
}
