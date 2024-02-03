<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getErrorResponse(int $code, string $message): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }

    protected function getSuccessResponse(Collection|array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true, 'data' => $data
        ], $code);
    }
}
