<?php

namespace App\Domain\Child\Http\Controllers;

use Carbon\Carbon;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Child\Entities\Child;
use App\Domain\Competition\Entities\Competition;
use App\Domain\Child\Repositories\Contracts\ChildRepository;
use App\Domain\Competition\Http\Resources\Competition\CompetitionResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Child\Http\Requests\ChildCompetition\ChildCompetitionStoreFormRequest;

class ChildCompetitionController extends Controller
{
    use Responder;

    /**
     * @var string
     */
    protected $resourceRoute = 'competitions';

    /**
     * @var mixed
     */
    private $childRepository;

    /**
     * @param ChildRepository $childRepository
     */
    public function __construct(ChildRepository $childRepository)
    {
        $this->childRepository = $childRepository;
    }

    /**
     * @param Competition $competition
     * @param ChildCompetitionStoreFormRequest $request
     */
    public function store(Competition $competition, ChildCompetitionStoreFormRequest $request)
    {
        $children = $this->childRepository->find($request->children);
        if ($competition->gender !== 'both' && !$children->contains('gender', $competition->gender)) {
            $this->setApiResponse(fn() => response()->json(['message' => sprintf('The competition requires gender of %s to participate', $competition->gender)], 422));
            $this->redirectBack();

            return $this->response();

        }
        foreach ($children as $child) {
            if ($child->location_id !== $competition->location_id) {
                $this->setApiResponse(fn() => response()->json(['message' => sprintf('The child is not located at %s to participate at the competition', $competition->location->name)], 422));
                $this->redirectBack();

                return $this->response();

            }
            $age = now()->diffInYears(Carbon::parse($child->birthdate));
            if ($age > $competition->max_age || $competition->min_age > $age) {
                $this->setApiResponse(fn() => response()->json(['message' => sprintf('The competition requires min age of %d and max age of %d to participate', $competition->min_age, $competition->max_age)], 422));
                $this->redirectBack();

                return $this->response();
            }
        };
        $competition->children()->syncWithoutDetaching($request->children);
        $this->setData('data', $competition);

        $this->redirectRoute("{$this->resourceRoute}.show", [$competition->id]);
        $this->useCollection(CompetitionResource::class, 'data');

        return $this->response();

    }
}
