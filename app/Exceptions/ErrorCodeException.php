<?php

namespace App\Exceptions;

use Exception;

class ErrorCodeException extends Exception
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
        return response()->json(
            [
                'errors' => [
                    'message' => 'Код недействителен'
                ]
            ],
            422
        );
    }
}
