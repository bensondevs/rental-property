<?php

namespace Tests\Unit\Services\Authentication;

use App\Models\User\PersonalAccessToken;
use App\Models\User\User;
use App\Services\Authentication\AuthenticationService;
use Database\Factories\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Services\Authentication\AuthenticationService
 *      To the tested service class.
 */
class AuthenticationServiceTest extends TestCase
{
    /**
     * Ensure the login method works properly.
     *
     * @test
     * @return void
     */
    public function login_method_works_properly(): void
    {
        $user = UserFactory::new(['password' => bcrypt('password')])->create();
        $credentials = [
            'identity' => $user->email,
            'password' => 'password',
        ];
        $loggedInUser = app(AuthenticationService::class)->login($credentials);
        $this->assertInstanceOf(User::class, $loggedInUser);
        $this->assertNotNull($loggedInUser->token);
        $personalAccessToken = PersonalAccessToken::whereTokenableType(User::class)
            ->whereTokenableId($loggedInUser->id)
            ->first();
        $this->assertInstanceOf(
            PersonalAccessToken::class,
            $personalAccessToken,
        );
    }
}
