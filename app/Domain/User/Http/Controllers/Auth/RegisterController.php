<?php

namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Entities\Role;
use App\Domain\User\Http\Requests\Auth\UserRegisterFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joovlly\DDD\Traits\Responder;

class RegisterController extends Controller
{
    use Responder;

    /**
     * @var mixed
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $this->setData('title', __('main.registration'), 'web');

        $this->addView('users::user.auth.register');
        $this->setApiResponse(fn() => response()->json(['message' => 'create_your_own_form'], 404));

        return $this->response();
    }

    /**
     * @param UserLoginFormRequest $request
     */
    public function store(UserRegisterFormRequest $request)
    {
        // dd($request->expectsJson(), 1);

        $user = $this->userRepository->create($request->validated());
        $user->roles()->attach(Role::whereSlug('user')->first());
        if ($request->expectsJson()) {
            $this->setData('meta', [
                'token' => $user->generateAuthToken(),
            ]);
        }
        $this->setData('data', $user);

        $this->useCollection(UserResource::class, 'data');
        $this->redirectRoute('dashboard');

        return $this->response();
    }
}
