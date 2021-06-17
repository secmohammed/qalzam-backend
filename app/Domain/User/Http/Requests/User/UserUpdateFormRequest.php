<?php

namespace App\Domain\User\Http\Requests\User;

use Illuminate\Support\Arr;

class UserUpdateFormRequest extends UserStoreFormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }

    /**
     * Determine if the user is authorized to make this request.
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
            'email' => ['required','email', 'unique:users,email,' . $this->user->id],
            'mobile' => ['required', 'unique:users,mobile,' . $this->user->id, 'regex:/^(010|011|012|015)([0-9]{8})$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:8|max:32|confirmed',
            'name_ar' => 'nullable|min:8|max:32',
            'role_id' => 'nullable|exists:roles,id',
        ];

        return array_merge(parent::rules(), $rules);
    }

    public function validated()
    {
        if ($password = $this->request->get('password')) {

            return array_merge(parent::validated(), [
                'password' => bcrypt($password),
            ]);

        }

        return Arr::except(parent::validated(), 'password');
    }
}
