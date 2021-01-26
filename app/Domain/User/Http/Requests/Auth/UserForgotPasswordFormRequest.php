<?php

namespace App\Domain\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserForgotPasswordFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|max:255|email|exists:users,email',
        ];
    }
}
