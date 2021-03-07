<?php

namespace App\Domain\Reservation\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;

class EnsureAccommodationIsAvailableTodayForReservationAtContractDays implements Rule
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
        $this->accommodationRepository = app(AccommodationRepository::class);
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
        $accommodation = $this->accommodationRepository->find($value);
        if (!$accommodation) {
            $this->message = sprintf('could not find an accommodation with id of %d', $value);

            return false;
        }
        if ($accommodation->type !== 'room') {
            return true;
        }
        if ($accommodation->contract()->whereJsonContains('days', strtolower(now()->dayName))->exists()) {
            return true;
        }
        $this->message = sprintf('The selected accommodation can not be selceted due to that the room %s is not available today to be reserved', $accommodation->name);

        return false;
    }
}
