<?php

namespace App\Domain\User\Http\Requests\Role;

use App\Domain\User\Entities\Role;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class RoleStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Role is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'boolean', function ($attribute, $value, $fail) {
                $valid = in_array($value, array_keys(Role::first()->permissions));
                if (! $valid) {
                    $fail($attribute . ' is invalid.');
                }
            }],
        ];

        return $rules;
    }

    public function validated()
    {
        $permissions = request()->get('permissions');
        foreach (Role::latest()->first()->permissions as $key => $value) {
            if (! array_key_exists($key, $permissions)) {
                $permissions[$key] = false;
            }
        }

        return array_merge(parent::validated(), compact('permissions'));
    }

    /**
     * @return mixed
     */
    public function validationData()
    {
        $permissions = array_fill_keys(array_keys($this->request->get('permissions') ?? []), true);
        $this->merge(
            compact('permissions')
        );

        return $this->all();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        =>  __('main.name'),
        ];
    }
}
