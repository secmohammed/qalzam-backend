<?php

namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Http\Requests\Auth\UserLoginFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Joovlly\DDD\Traits\Responder;

class LoginController extends Controller
{
    use AuthenticatesUsers, Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected $viewPath = 'user';

    /**
     * @var mixed
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     * @return mixed

     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->userRepository = $userRepository;
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(UserLoginFormRequest $request)
    {
        if (!auth()->attempt($request->only(['email', 'password']))) {
            $this->setData('message', __('main.invalid-credentials'));
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json([
                'message' => __('main.invalid-credentials'),
            ], 401));

            return $this->response();
        }
        $this->setData('data', $user = $this->userRepository->spatie()->where($request->only('email'))->firstOrFail());
        $this->setData('message', 'Logged In Successfully!');
        $this->useCollection(UserResource::class, 'data');
        if (Str::contains($request->header('User-Agent'), ['Android', 'iPhone'])) {
            if ($user->deviceTokens()->count()) {
                $user->deviceTokens()->where(['device' => $request->device])->update([
                    'token' => $request->device_token,
                ]);

                return $this->response();
            }

            $user->deviceTokens()->create([
                'device' => $request->device,
                'token' => $request->device_token,
            ]);

        }
        if ($request->wantsJson()) {
            $this->setData('meta', [
                'token' => $user->generateAuthToken(),
            ]);

            return $this->response();

        }

        $this->redirectRoute('dashboard');

        return $this->response();
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        auth()->logout();
        $this->setData('message', __('main.user.logout'));
        $this->redirectRoute('login');
        $this->setApiResponse(fn() => response()->json([
            'message' => __('main.user.logout'),
        ]));

        return $this->response();

    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view("{$this->domainAlias}::{$this->viewPath}.auth.login", [
            'title' => __('main.login'),
        ]);
    }
}
