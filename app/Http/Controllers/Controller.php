<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function responseError(string $message = ""): JsonResponse
    {
        $response = [
            "success" => false
        ];

        if (strlen($message) !== 0) {
            $response["message"] = $message;
        }

        return response()->json($response);
    }

    protected function responseSuccess(array $data = []): JsonResponse
    {
        $response = [
            "success" => true
        ];

        if (!empty($data)) {
            $response["data"] = $data;
        }

        return response()->json($response);
    }
}
