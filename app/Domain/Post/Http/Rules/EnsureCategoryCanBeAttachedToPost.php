<?php

namespace App\Domain\Post\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;

class EnsureCategoryCanBeAttachedToPost implements Rule
{
    /**
     * @var mixed
     */
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be attached to a valid category.';
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
        return $this->categoryRepository->where(['id' => $value])->where('type', 'post')->where('status', 'active')->exists();
    }
}
