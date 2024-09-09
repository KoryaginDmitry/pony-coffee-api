<?php

namespace App\Http\Controllers;

use App\Jobs\SendExceptionToTelegram;
use App\Traits\SendResponseTrait;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, SendResponseTrait, ValidatesRequests;

    public function createErrorResponse(string $error, Exception $exception): JsonResponse
    {
        SendExceptionToTelegram::dispatch($exception);

        $error = $error.'.'.__('errors.end_message');

        return $this->sendErrorResponse($error, 400);
    }
}
