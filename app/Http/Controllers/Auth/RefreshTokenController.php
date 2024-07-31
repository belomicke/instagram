<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        return $this->responseSuccess([
            'token' => $this->authService->refreshAccessToken()
        ]);
    }
}
