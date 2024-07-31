<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserRepository $users
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $login = $request->get("login");
        $password = $request->get("password");

        $user = $this->users->getByLogin($login);

        if (!$user) {
            return $this->responseError("invalid credentials");
        }

        if (!Hash::check($password, $user->password)) {
            return $this->responseError("invalid credentials");
        }

        if (str_contains($login, "@")) {
            if (Auth::attempt(['email' => $login, 'password' => $password])) {
                $request->session()->regenerate();
            }
        } else {
            if (Auth::attempt(['username' => $login, 'password' => $password])) {
                $request->session()->regenerate();
            }
        }

        return $this->responseSuccess();
    }
}
