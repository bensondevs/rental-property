<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ChangePasswordRequest;
use App\Models\User\User;
use App\Services\Authentication\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Authentication service instance container property.
     *
     * @var AuthenticationService
     */
    private AuthenticationService $authenticationService;

    /**
     * Create forgot password controller instance.
     *
     * @param AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Get user's security question.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function securityQuestion(Request $request): JsonResponse
    {
        $user = User::findByIdentity($request->input('identity'), true);
        $question = $user->getSecurityQuestion();

        return response()->json(['question' => $question]);
    }

    /**
     * Give answer to the security question.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function answerQuestion(Request $request): JsonResponse
    {
        $user = User::findByIdentity($request->input('identity'), true);
        $answer = $request->input('answer');

        return $user->checkAnswer($answer) ?
            response()->json(['status' => 'success', 'message' => 'Answer is correct']) :
            response()->json(['status' => 'error', 'message' => 'Answer is incorrect']);
    }

    /**
     * Send forgot password mail to the user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendForgotPasswordMail(Request $request): JsonResponse
    {
        $user = User::findByIdentity($request->input('identity'), true);
        $this->authenticationService->sendResetPasswordMail($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Reset password email sent!',
        ]);
    }

    /**
     * Change password of the given user.
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $token = $request->input('token');
        $password = $request->input('password');
        $this->authenticationService->changePasswordByResetToken(
            $token,
            $password,
        );

        return response()->json([
            'status' => 'success',
            'message' => 'User password has been changed successfully.',
        ]);
    }
}
