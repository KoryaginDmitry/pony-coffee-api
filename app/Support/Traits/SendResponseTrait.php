<?php

namespace App\Support\Traits;

use Illuminate\Http\JsonResponse;

trait SendResponseTrait
{
    /**
     * @param array $response
     * @return JsonResponse
     */
    public function sendResponse(array $response) : JsonResponse
    {
        return response()->json(
            [
                "data" => $response['data'],
                "errors" => $response['errors'],
                "status" => $response['status'],
            ],
            $response['code']
        );
    }

    /**
     * @param array|string $errors
     * @param int $code
     * @return JsonResponse
     */
    public function sendErrorResponse(array|string $errors, int $code = 422) : JsonResponse
    {
        $errors = (array) $errors;

        $response = [
            'data' => null,
            'errors' => [
                'messages' => $errors
            ],
            'status' => false,
            'code' => $code
        ];

        return $this->sendResponse($response);
    }

}
