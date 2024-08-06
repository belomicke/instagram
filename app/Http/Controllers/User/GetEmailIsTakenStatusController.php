<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetEmailIsTakenStatusController extends Controller
{
    public function __construct(
        private readonly UserRepository $users
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');

        $user = $this->users->getByEmail(email: $email);

        return $this->responseSuccess([
            'exists' => $user !== null
        ]);
    }
}
