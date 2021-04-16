<?php

namespace App\Domain\Reservation\Http\Requests\Reservation;

use App\Domain\Reservation\Http\Rules\EnsureAccommodationIsAvailableTodayForReservationAtContractDays;
use App\Domain\Reservation\Http\Rules\EnsureEndDateIsSameDayAsStartDate;
use App\Domain\Reservation\Http\Rules\EnsureStartDateOfReservationInSameBranchDay;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ReservationStoreFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('main.name'),
        ];
    }

    /**
     * Determine if the Reservation is authorized to make this request.
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
        $rules = [
            'start_date' => ['required','after_or_equal:' . now()->format('Y-m-d H:i:s')],
            'end_date' => ['nullable', 'after_or_equal:' . $this->request->get('start_date'), new EnsureEndDateIsSameDayAsStartDate($this->request->get('start_date'))],
            'accommodation_id' => [
                'required',
                'exists:accommodations,id',new EnsureStartDateOfReservationInSameBranchDay()
                // new EnsureAccommodationIsAvailableTodayForReservationAtContractDays,
            ],
            'user_id' => 'required|exists:users,id',
            "notes" => "nullable",

        ];

        if (request()->is('/api/*')) {
            unset($rules['user_id']);
        }

        return $rules;
    }

    public function validated()
    {
        $validated = [
            'creator_id' => auth()->id(),

        ];

        if (!$this->request->get('end_date') && $this->method() !== "PUT") {
            $validated = array_merge($validated, [
                'end_date' => Carbon::parse($this->request->get('start_date'))->addHour(4)->format('Y-m-d H:i:s'),

            ]);
        }

        if (request()->is('/api/*')) {
            $validated = array_merge($validated, [
                'user_id' => auth()->id(),
            ]);
        }

        return array_merge(parent::validated(), $validated);
    }

    /**
     * @return mixed
     */
    public function validationData()
    {
        $this->merge(['price' => null]);

        return $this->all();
    }

}
