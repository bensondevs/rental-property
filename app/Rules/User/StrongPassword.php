<?php

namespace App\Rules\User;

use App\Services\Utility\ValidationService;
use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * Validation service instance container property.
     *
     * @var ValidationService
     */
    private ValidationService $validationService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->validationService = new ValidationService(true);
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
        return $this->validationService->isAStrongPassword($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Unknown error occurred in strong password check.';
    }
}
