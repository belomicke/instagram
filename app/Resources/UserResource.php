<?php

namespace App\Resources;

use App\Models\User;

class UserResource
{
    public function toJson(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username
        ];
    }
}
