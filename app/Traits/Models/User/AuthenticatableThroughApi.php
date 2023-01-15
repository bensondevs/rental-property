<?php

namespace App\Traits\Models\User;

trait AuthenticatableThroughApi
{
    /**
     * Get authentication token for current user instance.
     *
     * @return string
     */
    public function getAuthToken(): string
    {
        if (empty($this->token)) {
            $this->token = $this->createToken($this->password)->plainTextToken;
        }

        return $this->token;
    }

    /**
     * Clear authentication token for given authenticatable instance.
     *
     * @return bool
     */
    public function clearToken(): bool
    {
        return $this->tokens()->forceDelete();
    }
}
