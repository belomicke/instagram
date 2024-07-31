<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $name = $request->post('name', "");
        $username = $request->post('username');
        $email = $request->post('email');
        $password = $request->post('password');

        $result = $this->userService->createUser(
            username: $username,
            email: $email,
            password: $password,
            name: $name
        );

        if ($result[0] === false) {
            return $this->responseError(message: $result[1]);
        }

        return $this->responseSuccess();
    }
}
