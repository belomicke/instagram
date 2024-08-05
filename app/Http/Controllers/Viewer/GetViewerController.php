<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetViewerController extends Controller
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly UserResource $userResource
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $viewer = $this->users->getViewer();
        
        return response()->json([
            'success' => true,
            'data' => [
                'viewer' => $this->userResource->toJson(user: $viewer)
            ]
        ]);
    }
}
