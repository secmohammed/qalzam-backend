<?php

namespace App\Domain\Product\Http\Requests\Template;

use App\Domain\Product\Http\Requests\Template\TemplateStoreFormRequest;

class TemplateUpdateFormRequest extends TemplateStoreFormRequest
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
     * Determine if the template is authorized to make this request.
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
            'name' => 'required|string|max:255|unique:templates,name,' . $this->template->id,
        ];

        return array_merge(parent::rules(), $rules);
    }
}
