<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $login = $request->get(key: 'login');
        $password = $request->get(key: 'password');

        $success = $this->authService->login(
            login: $login,
            password: $password
        );

        if ($success === false) {
            return $this->responseError(message: 'invalid credentials');
        }

        $request->session()->regenerate();

        return $this->responseSuccess();
    }
}
