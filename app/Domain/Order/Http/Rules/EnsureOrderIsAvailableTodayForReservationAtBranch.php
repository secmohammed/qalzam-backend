<?php

namespace App\Domain\Order\Http\Rules;

use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EnsureOrderIsAvailableTodayForReservationAtBranch implements Rule
{
    /**
     * @var mixed
     */
    private $message;

    /**
     * @param $reservation
     */
    public function __construct()
    {
        $this->branchRepository = app(BranchRepository::class);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
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
        $branch = $this->branchRepository->whereId(request()->branch_id)->first();
        $shift = $branch->shifts->where("day", strtolower(Carbon::now()->isoFormat("dddd")))->first();
        // dd($branch->shifts);
        // dd(Carbon::now()->greaterThanOrEqualTo(Carbon::parse($branch->start_time)) && Carbon::now()->lessThanOrEqualTo(Carbon::parse($branch->end_time)), $branch->start_time, $branch->end_time, $branch);
        if (!$shift) {
            $this->message = sprintf('could not find a shift this branch', $branch->name);

            return false;
        }
        if (strtolower($shift->day) !== strtolower(Carbon::now()->isoFormat("dddd"))) {
            $this->message = sprintf('The selected branch can not be selected due to that the branch %s is not available today ', $branch->name);

            return false;
        }
        if (Carbon::now()->greaterThanOrEqualTo(Carbon::parse($shift->start_time)) && Carbon::now()->lessThanOrEqualTo(Carbon::parse($shift->end_time))) {
            return true;
        }
        $this->message = sprintf('The selected branch can not be selceted due to that the branch %s is not available at this time ', $branch->name);

        return false;
    }
}
