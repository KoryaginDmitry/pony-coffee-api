<?php

namespace App\Support\Classes;

use Illuminate\Http\JsonResponse;

/**
 * ErrorResponse class
 *
 * @category Support
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ErrorResponse
{
    /**
     * Returns data for response in case of error
     *
     * @param string|array $error
     * @param int $code
     * @return JsonResponse
     */
    public static function sendErrorResponse(string|array $error, int $code = 422) : JsonResponse
    {
        $error = (array) $error;

        return response()->json(
            [
                'status' => false,
                'errors' => [
                    'message' => $error
                ]
            ],
            $code
        );
    }
}
