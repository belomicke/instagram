<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function create(
        string $username,
        string $email,
        string $password,
        string $name = "",
    ): User {
        return User::create([
            "name" => $name,
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ])->fresh();
    }

    public function getByUsername(string $username): User|null
    {
        return User::query()->where("username", $username)->first();
    }

    public function getByEmail(string $email): User|null
    {
        return User::query()->where("email", $email)->first();
    }

    public function getByLogin(string $login): User|null
    {
        if (str_contains($login, "@")) {
            return $this->getByEmail(email: $login);
        } else {
            return $this->getByUsername(username: $login);
        }
    }

    public function getViewer(): Authenticatable|User
    {
        return Auth::guard("sanctum")->user();
    }
}
