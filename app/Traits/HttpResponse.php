<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Http\Resources\Api\v1\UserCollection;
use App\Http\Resources\Api\v1\UserResource;
use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    /**
     * Return a message success in json for API responses.
     *
     * @param string                            $message
     * @param int                               $code
     * @param array|UserCollection|UserResource $data
     *
     * @return JsonResponse
     */
    public function success(string $message, int $code, array | UserCollection | UserResource $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => $code,
            'data'    => $data,
        ], $code);
    }

    /**
     * Return a message error in json for API responses.
     *
     * @param string $message
     * @param int    $code
     * @param array  $errors
     * @param array  $data
     *
     * @return JsonResponse
     */
    public function error(string $message, int $code, array $errors, array $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => $code,
            'errors'  => $errors,
            'data'    => $data,
        ], $code);
    }
}
