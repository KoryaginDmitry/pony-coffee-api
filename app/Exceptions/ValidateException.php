<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ValidateException extends Exception
{
    /**
     * Code response
     *
     * @var integer
     */
    protected $code = 422;

    /**
     * Report the exception
     *
     * @return void
     */
    public function report()
    {

    }

    /**
     * Render the exception as an HTTP response
     *
     * @param Illuminate\Http\Request $request 
     * 
     * @return JsonResponse
     */
    public function render($request) : JsonResponse
    {
        return response()->json(
            [
                'data' => [],
                'error' => $this->getMessage(),
                'status' => false
            ],
            $this->code
        );
    }
}
