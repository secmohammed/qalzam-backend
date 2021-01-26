<?php

namespace App\Common\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnsureParentIsntSelf implements Rule
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @param $type
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you cannot attach the same record to be a parent of itself';
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
        return $this->id !== $value;
    }
}
