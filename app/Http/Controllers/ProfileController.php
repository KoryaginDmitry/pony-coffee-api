<?php

namespace App\Http\Controllers;

use App\Service\ProfileService;
use Illuminate\Http\Request;


class ProfileController extends BaseController
{
    public function __construct(protected ProfileService $service)
    {
        
    }

    public function getUser()
    {   
        return $this->sendResponse(
            $this->service->user()
        );
    }

    public function update(Request $request)
    {   
        return $this->sendResponse(
            $this->service->update($request)
        );
    }

    public function newPassword(Request $request)
    {
        return $this->sendResponse(
            $this->service->newPassword($request)
        );
    }
}
