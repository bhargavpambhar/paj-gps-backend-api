<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Standard success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Request successful', $code = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code
        ], $code);
    }

    /**
     * Standard error response.
     *
     * @param mixed $errors
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($errors = null, $message = 'An error occurred', $code = 400)
    {
        return response()->json([
            'status' => false,
            'errors' => $errors ?? [],
            'message' => $message,
            'code' => $code
        ], $code);
    }
}
