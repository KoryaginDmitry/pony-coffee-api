<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait SendResponseTrait
{
    protected function sendResponse(array|string $data = [], $code = 200): JsonResponse
    {
        return response()->json([
            'data' => (array) $data,
        ], $code);
    }

    protected function sendErrorResponse(array|string $errorArray = [], int $responseCode = 422): JsonResponse
    {
        return response()->json([
            'errors' => (array) $errorArray,
        ], $responseCode);
    }
}
