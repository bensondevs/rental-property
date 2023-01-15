<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\LogoutRequest;
use App\Http\Resources\User\LoginUserResource;
use App\Services\Authentication\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
     * Authentication service container property.
     *
     * @var AuthenticationService
     */
    private AuthenticationService $authenticationService;

    /**
     * Create authentication controller instance.
     *
     * @param AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Login the user into the application.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authenticationService->login(
            $request->only(['identity', 'password']),
        );

        return response()->json([
            'user' => new LoginUserResource($user),
            'status' => 'success',
            'message' => 'Successfully logged into the application.',
        ]);
    }

    /**
     * Logout the authenticated user.
     *
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $user = $request->user();
        $this->authenticationService->logout($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out from the application',
        ]);
    }
}
