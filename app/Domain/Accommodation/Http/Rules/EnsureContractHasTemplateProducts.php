<?php

namespace App\Domain\Accommodation\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Domain\Accommodation\Repositories\Contracts\ContractRepository;

class EnsureContractHasTemplateProducts implements Rule
{
    /**
     * @var mixed
     */
    private $contractRepository;

    public function __construct()
    {
        $this->contractRepository = app(ContractRepository::class);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must exists first and attached to a template that has products.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->contractRepository->where(['id' => $value])->has('template.products')->exists();
    }
}
