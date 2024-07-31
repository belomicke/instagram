<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

readonly class AuthService
{
    public function __construct(
        private UserRepository $users
    ) {}

    public function login(string $login, string $password): string
    {
        $user = $this->users->getByLogin($login);

        if (!$user) {
            return "";
        }

        if (!Hash::check($password, $user->password)) {
            return "";
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
    }

    public function refreshAccessToken(): string
    {
        return auth()->refresh(true, true, true);
    }
}
