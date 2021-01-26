<?php

namespace App\Domain\Child\Http\Requests\Child;

use App\Domain\Child\Http\Requests\Child\ChildStoreFormRequest;

class ChildUpdateFormRequest extends ChildStoreFormRequest
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
     * Determine if the child is authorized to make this request.
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
        return array_merge(parent::rules(), [
            'child-avatar' => 'nullable|image|mimes:png,jpeg,jpg',
            'child-birthdate-certificate' => 'nullable|image|mimes:png,jpeg,jpg',
            'national_id' => ['nullable', 'unique:children,national_id,' . $this->child->id, 'regex:/^(2|3)[0-9][1-9][0-1][1-9][0-3][1-9](01|02|03|04|11|12|13|14|15|16|17|18|19|21|22|23|24|25|26|27|28|29|31|32|33|34|35|88)\d\d\d\d\d$/'],

        ]);
    }
}
