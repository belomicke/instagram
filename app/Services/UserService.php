<?php

namespace App\Services;

use App\Repositories\UserRepository;

readonly class UserService
{
    public function __construct(
        private UserRepository $users
    ) {}

    public function createUser(
        string $username,
        string $email,
        string $password,
        string $name = "",
    ): array
    {
        $emailIsTaken = $this->users->getByEmail(email: $email);

        if ($emailIsTaken) {
            return [false, "email is taken"];
        }

        $usernameIsTaken = $this->users->getByUsername(username: $username);

        if ($usernameIsTaken) {
            return [false, "username is taken"];
        }

        $this->users->create(
            username: $username,
            email: $email,
            password: $password,
            name: $name
        );

        return [true, ""];
    }
}
