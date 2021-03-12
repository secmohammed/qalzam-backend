<?php

namespace App\Domain\Accommodation\Http\Rules;

use App\Domain\Product\Repositories\Contracts\TemplateRepository;
use Illuminate\Contracts\Validation\Rule;

class EnsureTemplateHasProducts implements Rule
{
    /**
     * @var mixed
     */
    private $templateRepository;

    public function __construct()
    {
        $this->templateRepository = app(TemplateRepository::class);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must exists first and has products.';
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
        return $this->templateRepository->where(['id' => $value])->has('products')->exists();
    }
}
