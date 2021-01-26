<?php

namespace App\Domain\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Dashboard\Entities\Dashboard;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Domain\Child\Repositories\Contracts\ChildRepository;
use App\Domain\Dashboard\Repositories\Contracts\DashboardRepository;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class DashboardController extends Controller
{
    use Responder;

    /**
     * @var DashboardRepository
     */
    protected $competitionRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'dashboards';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'dashboards';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'dashboard';

    /**
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(CompetitionRepository $competitionRepository, PostRepository $postRepository, UserRepository $userRepository, ChildRepository $childRepository)
    {
        $this->competitionRepository = $competitionRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->childRepository = $childRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $competitionsCount = $this->competitionRepository->where('status', 'active')->count();
        $childrenCount = $this->childRepository->where('status', 'active')->count();
        $postsCount = $this->postRepository->where('status', 'approved')->count();
        $usersCount = $this->userRepository->where('status', 'active')->count();
        $competitions = $this->competitionRepository->where('status', 'active')->withCount('children')->latest()->limit(5)->get();
        $hotCompetition = $this->competitionRepository->where('status', 'active')->has('children.feeds', '>', 1)
            ->withCount(['children', 'feeds'])->with('children', 'children.location')
            ->orderBy(
                \DB::raw("`feeds_count` + `children_count`"), "desc"
            )
            ->first();

        return view('welcome', compact('competitionsCount', 'postsCount', 'usersCount', 'childrenCount', 'competitions', 'hotCompetition'));
    }
}
