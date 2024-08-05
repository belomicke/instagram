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

    public function login(string $login, string $password): bool
    {
        $user = $this->users->getByLogin($login);

        if (!$user) {
            return false;
        }

        if (!Hash::check($password, $user->password)) {
            return false;
        }

        if (str_contains($login, "@")) {
            return Auth::attempt(['email' => $login, 'password' => $password]);
        } else {
            return Auth::attempt(['username' => $login, 'password' => $password]);
        }
    }
}
