<?php

namespace App\Models\User;

use App\Traits\Models\User\AuthenticatableThroughApi;
use App\Traits\Models\User\HasSecurityQuestion;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use AuthenticatableThroughApi, HasSecurityQuestion;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Find user by given email or username.
     *
     * @param string $emailOrUsername
     * @param bool $abortIfFail
     * @return User|null
     */
    public static function findByIdentity(
        string $emailOrUsername,
        bool $abortIfFail = false,
    ): self|null {
        $user = User::whereEmail($emailOrUsername)
            ->orWhere('username', $emailOrUsername)
            ->first();
        if (is_null($user) and $abortIfFail) {
            abort(404, 'There is no user with email or username of ' . $emailOrUsername);
        }

        return $user;
    }

    /**
     * Check whether given password is match with user password.
     *
     * @param string $password
     * @return bool
     */
    public function isPasswordMatch(string $password): bool
    {
        return hash_check($password, $this->password);
    }
}
