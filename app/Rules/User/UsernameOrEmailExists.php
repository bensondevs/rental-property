<?php

namespace App\Rules\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UsernameOrEmailExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return User::whereEmail($value)
            ->orWhereUsername($value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Email or username does not exist in database.';
    }
}
