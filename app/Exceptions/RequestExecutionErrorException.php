<?php

namespace App\Exceptions;

use App\Support\Classes\ErrorResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class RequestExecutionErrorException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function render($request) : JsonResponse
    {
        return ErrorResponse::sendErrorResponse('Ошибка выполнения запросв', 500);
    }
}
