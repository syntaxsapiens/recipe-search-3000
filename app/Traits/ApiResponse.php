<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'error' => false,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse($message, $errors = [], $statusCode = 400): JsonResponse
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
