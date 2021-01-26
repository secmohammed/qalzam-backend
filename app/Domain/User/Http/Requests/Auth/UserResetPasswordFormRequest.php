<?php

namespace App\Domain\User\Http\Requests\Auth;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserResetPasswordFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => __('main.password'),
        ];
    }

    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
