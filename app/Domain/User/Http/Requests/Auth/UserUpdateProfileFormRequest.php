<?php

namespace App\Domain\User\Http\Requests\Auth;

use Illuminate\Support\Arr;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserUpdateProfileFormRequest extends FormRequest
{
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
            'password' => 'nullable|min:8|max:32|confirmed',
            'email' => 'required|unique:users,email,' . $this->user()->id,
            'mobile' => ['required', 'regex:/^(010|011|012|015)([0-9]{8})$/', 'unique:users,mobile,' . $this->user()->id],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        return $rules;
    }

    public function validated()
    {
        if ($this->request->get('password')) {
            return parent::validated();
        }

        return Arr::except(parent::validated(), 'password');
    }
}
