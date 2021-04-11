<?php

namespace App\Domain\User\Http\Requests\User;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserFastStoreFormRequest extends FormRequest
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
            'name_ar' => __('main.name_ar'),
            'password' => __('main.password'),
            'email' => __('main.email'),
            'national_id' => __('main.national_id'),
            'mobile' => __('main.mobile'),
            'image' => __('main.image'),
            'role_id' => __('main.role'),
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
        // dd($this->request);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email:rfc,dns|unique:users,email',
            'mobile' => ['required', 'unique:users,mobile'],
        ];

        return $rules;
    }

}
