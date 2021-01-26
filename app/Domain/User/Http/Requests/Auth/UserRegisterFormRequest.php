<?php

namespace App\Domain\User\Http\Requests\Auth;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserRegisterFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('main.name'),
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => 'required|min:8|max:32|confirmed',
            'email' => 'required|unique:users,email',
            'mobile' => ['required', 'regex:/^(010|011|012|015)([0-9]{8})$/', 'unique:users,mobile'],
        ];

        return $rules;
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'password' => bcrypt($this->request->get('password')),
        ]);
    }
}
