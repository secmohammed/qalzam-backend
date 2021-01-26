<?php

namespace App\Common\Http\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class UniqueValidationArNameRule implements Rule
{
    /**
     * @var mixed
     */
    private $class;

    /**
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be Unique.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $lowerClassName = lcfirst(explode('\\', $this->class)[4]);
        if (request()->method() === 'POST') {
            return !DB::table('translations')->where('translatable_type', $this->class)->where('value', $value)->exists();
        }

        return !DB::table('translations')->where('translatable_type', $this->class)->where('value', $value)->where('translatable_id', '!=', request()->route($lowerClassName)->id)->exists();

    }
}
