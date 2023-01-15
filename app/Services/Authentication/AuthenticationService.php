<?php

namespace App\Services\Authentication;

use App\Models\User\PasswordReset;
use App\Models\User\User;

/**
 * @see \Tests\Unit\Services\Authentication\AuthenticationServiceTest
 *      To the service class unit tester.
 */
class AuthenticationService
{
	/**
	 * Create New Service Instance
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

    /**
     * Authenticate the logging in user.
     *
     * @param array $credentials
     * @return User
     * @see \Tests\Unit\Services\Authentication\AuthenticationServiceTest
     *      To the method unit tester class.
     */
    public function login(array $credentials = []): User
    {
        $loggingInUser = User::findByIdentity(
            $credentials['identity'],
            true,
        );

        if (!$loggingInUser->isPasswordMatch($credentials['password'])) {
            abort(422, 'Mismatch given password in the record.');
        }

        $this->postLoginChecks($loggingInUser);

        $loggingInUser->getAuthToken(); // Get or create token
        return $loggingInUser;
    }

    /**
     * Check on user after login is successful before creating token.
     *
     * This method shall abort when the user does not fulfill certain standards.
     *
     * @param User $user
     * @return void
     */
    public function postLoginChecks(User $user): void
    {
        // Check whether user's email is verified.
        if (!$user->hasVerifiedEmail()) {
            abort(403, 'You need to verify the email before logging in.');
        }

        // And many more later...
    }

    /**
     * Logout specified user from the application.
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        // Destroy all token which can authenticate the user.
        $user->clearToken();

        // Record log for the current user.
        //

        // And many more actions...
    }

    /**
     * Send reset password email to the given user.
     *
     * @param User $user
     * @return void
     */
    public function sendResetPasswordMail(User $user): void
    {
        $user->sendPasswordResetNotification('reset_password');
    }

    /**
     * Change password by given token.
     *
     * @param string $token
     * @param string $password
     * @return User
     */
    public function changePasswordByResetToken(
        string $token,
        string $password,
    ): User {
        $resetPassword = PasswordReset::findByToken($token, true);
        $user = $resetPassword->user ?: $resetPassword->user()->first();

        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }
}
