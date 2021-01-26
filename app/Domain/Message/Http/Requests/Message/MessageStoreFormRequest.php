<?php

namespace App\Domain\Message\Http\Requests\Message;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class MessageStoreFormRequest extends FormRequest
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
     * Determine if the Dashboard is authorized to make this request.
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
            'title' => 'required|string',
            'body' => ['required', 'string'],
            'type' => 'required|in:push_notification,sms',
            'delay' => 'nullable|after_or_equal:' . now()->format('Y-m-d H:i:s'),
            'competition_id' => 'nullable|exists:competitions,id',
        ];

        return $rules;
    }

    public function validated()
    {
        return parent::validated() + ['user_id' => auth()->id()];
    }
}
