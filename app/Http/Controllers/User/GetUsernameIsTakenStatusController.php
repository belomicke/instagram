<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUsernameIsTakenStatusController extends Controller
{
    public function __construct(
        private readonly UserRepository $users
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $username = $request->get('username');
        $user = $this->users->getByUsername(username: $username);

        return $this->responseSuccess([
            'exists' => $user !== null
        ]);
    }
}
