<?php

namespace App\Domain\User\Http\Controllers\Auth;

use Joovlly\DDD\Traits\Responder;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\Contracts\RemindableRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class VerifyCodeController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'users';

    /**
     * View Path.
     *
     * @var string
     */
    protected $viewPath = 'user';

    /**
     * @var mixed
     */
    private $remindableRepository;

    /**
     * @param RemindableRepository $remindableRepository
     */
    public function __construct(RemindableRepository $remindableRepository)
    {
        $this->remindableRepository = $remindableRepository;
    }

    /**
     * @return mixed
     */
    public function show(User $user, $token)
    {
        $remindable = $user->remindables()->where([
            'type' => 'reminder',
            'token' => $token,
            'status' => 'active',
            'completed_at' => null,
            [
                'expires_at',
                '>=',
                now()->subHours(config("qalzam.remindable.expiration"))->format('Y-m-d H:i'),
            ],
        ])->firstOrFail();

        $this->setData('title', __('main.verify_token'), 'web');
        $this->setData('data', $remindable, 'web');

        $this->addView('users::user.auth.verify_token');

        $this->setApiResponse(fn() => response()->json(['token' => $remindable->token]));

        return $this->response();
    }
}
