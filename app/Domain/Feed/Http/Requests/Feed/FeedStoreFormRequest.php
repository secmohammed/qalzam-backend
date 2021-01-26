<?php

namespace App\Domain\Feed\Http\Requests\Feed;

use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class FeedStoreFormRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $competitionRepository;

    /**
     * @param CompetitionRepository $competitionRepository
     */
    public function __construct(CompetitionRepository $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'feed-isomorphic' => __('main.feed_media'),
        ];
    }

    /**
     * Determine if the Feed is authorized to make this request.
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

        if (request()->expectsJson() || !isset(request()->serverMemo)) {
            $data = request()->all();
        } else {
            $data = request()->serverMemo['data'];
        }

        // $competition = $this->competitionRepository->findOrFail($data['competition_id']);
        // if ($competition->type === 'check-in') {

        // } else {
        $rules = [
            'description' => 'required',
            'feed-isomorphic' => ['array', 'nullable'],
            'feed-isomorphic.*' => ['required', 'file' /* new EnsureFeedIsIsomorphic($competition)*/],
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'checked_in_location' => ['nullable', 'min:20'],

        ];
        // }
        if (!request()->wantsJson()) {
            $webRules = [
                'status' => ['nullable', 'in:pending,winner,disqualified'],
            ];
        }
        $apiRules = [
            'child_id' => ['required', 'exists:children,id'],
            'competition_id' => ['required'],
        ];

        return array_merge($apiRules, $webRules ?? [], $rules);
    }

    public function validated()
    {
        $status = request()->get('status') === null ? 'pending' : request()->get('status');

        return array_merge(parent::validated(), [
            'status' => $status,
            'user_id' => auth()->id(),
        ]);
    }
}
