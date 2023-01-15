<?php

namespace App\Http\Requests\Authentication;

use App\Rules\User\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'exists:password_resets,token'],
            'password' => ['required', 'string', new StrongPassword()],
            'confirm_password' => ['required', 'string', 'same:password'],
        ];
    }
}
