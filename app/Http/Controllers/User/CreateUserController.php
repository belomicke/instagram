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

        $nameIsValid = $this->isValidName(name: $name);

        if (strlen($nameIsValid)) {
            return $this->responseError($nameIsValid);
        }

        $emailIsValid = $this->isValidEmail(email: $email);

        if (!$emailIsValid) {
            return $this->responseError("provided email is incorrect");
        }

        $usernameIsValid = $this->isValidUsername(username: $username);

        if (strlen($usernameIsValid)) {
            return $this->responseError($usernameIsValid);
        }

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

    private function isValidName(string $name): string
    {
        if (strlen($name) > 64) {
            return "name is too long";
        }

        return "";
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidUsername(string $username): string
    {
        if (strlen($username) < 5) {
            return "username is too short";
        }

        if (strlen($username) > 32) {
            return "username is too long";
        }

        for ($index = 0; $index < strlen($username); $index++) {
            if (!preg_match("/^[a-zA-Z0-9_.]$/", $username[$index])) {
                return "username contains invalid characters";
            }
        }

        if (ctype_digit($username)) {
            return "username can not contains only digits";
        }

        $firstLetter = $username[0];

        if ($firstLetter === "." || $firstLetter === "_") {
            return "username can not starts by special characters";
        }

        $lastLetter = $username[strlen($username) - 1];

        if ($lastLetter === "." || $lastLetter === "_") {
            return "username can not ends by special characters";
        }

        for ($index = 0; $index < strlen($username); $index++) {
            if ($username[$index] === "." && $username[$index - 1] === ".") {
                return "username can not contains two dots in a row";
            }
        }

        return "";
    }
}
