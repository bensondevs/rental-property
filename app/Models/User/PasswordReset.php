<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * Find password reset instance by token.
     *
     * @param string $token
     * @param bool $abortIfFail
     * @return static|null
     */
    public static function findByToken(
        string $token,
        bool $abortIfFail = false,
    ): self|null {
        $reset = self::whereToken($token);

        return $abortIfFail ? $reset->firstOrFail() : $reset->first();
    }

    /**
     * Get user as the owner of password reset record instance.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
