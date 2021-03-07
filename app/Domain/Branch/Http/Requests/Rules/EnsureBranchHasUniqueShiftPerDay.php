<?php

namespace App\Domain\Branch\Http\Requests\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;

class EnsureBranchHasUniqueShiftPerDay implements Rule
{
    /**
     * @var mixed
     */
    private $day;

    /**
     * @param $type
     */
    public function __construct($day, BranchRepository $branchRepository)
    {
        $this->day = $day;
        $this->branchRepository = $branchRepository;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you can not add more than one shift to a branch at same day';
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
        return !$this->branchRepository->find($value)->shifts()->where('status', 'active')->where(['day' => $this->day])->exists();
    }
}
