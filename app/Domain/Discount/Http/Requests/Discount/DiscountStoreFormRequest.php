<?php

namespace App\Domain\Discount\Http\Requests\Discount;

use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class DiscountStoreFormRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Determine if the Discount is authorized to make this request.
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
            'code' => 'required|max:32|unique:discounts,code',
            'value' => 'required|integer|min:1|max:99',
            'type' => 'required|in:percentage,amount',
            'number_of_usage' => 'required|integer|min:1|max:200',
            'expires_at' => 'nullable|after_or_equal:' . now()->format('Y-m-d H:i'),
            'users' => ['nullable', 'array'],
            'users.*' => ['required', 'exists:users,id'],
            'broadcast' => 'required_if:users,==,null|boolean',
            'status' => 'nullable|in:active,inactive',
            'discountable_id' => 'required', // TODO : validate discountable_id based on its type at the database that it exists.
            'discountable_type' => 'required|in:category,product,variation',
        ];
    }

    public function validated()
    {

        if ($this->request->get('broadcast')) {

            return array_merge(parent::validated(), [
                'users' => $this->userRepository->whereHas('roles', function ($query) {
                    $query->whereSlug('user');
                })->pluck('id')->toArray(),
            ]);
        }
       return array_merge(parent::validated(), [
            'users' =>collect($this->request->get('users'))->pluck('id')

        ]);


    }

}
