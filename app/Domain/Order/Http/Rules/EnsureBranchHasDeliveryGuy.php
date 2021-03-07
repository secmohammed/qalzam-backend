<?php

namespace App\Domain\Order\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;

class EnsureBranchHasDeliveryGuy implements Rule
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
        $this->branch = app(BranchRepository::class)->with([
            'users' => function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->whereSlug('delivery');
                });
            },
        ])->find($id);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you cannot attach this user to order as this delivery guy is not part of this branch.';
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
        return $this->branch->users->contains('id', $value);
    }
}
