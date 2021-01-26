<?php

namespace App\Domain\User\Http\Controllers\Auth;

use Mail;
use Joovlly\DDD\Traits\Responder;
use App\Domain\User\Mail\ResetPassword;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Domain\User\Repositories\Contracts\RemindableRepository;
use App\Domain\User\Repositories\Contracts\PasswordResetRepository;
use App\Domain\User\Http\Requests\Auth\UserForgotPasswordFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class ForgotPasswordController extends Controller
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
    private $reminders;

    /**
     * @var mixed
     */
    private $userRepository;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    //use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $reminders
     */
    public function __construct(UserRepository $userRepository, RemindableRepository $reminders)
    {
        $this->userRepository = $userRepository;
        $this->reminders = $reminders;
    }

    /**
     * @param UserForgotPasswordFormRequest $request
     * @return mixed
     */
    public function __invoke(UserForgotPasswordFormRequest $request)
    {
        $user = $this->userRepository->whereEmail($request->validated())->firstOrFail();
        \Illuminate\Support\Facades\Mail::to($user->email)->queue(
            new \App\Domain\User\Mail\ResetPassword(
                $user,
                $this->reminders->hasOrCreateToken($user, 'reminder')
            )
        );
        $this->setData('message', __('main.reset password mail sent'));
        $this->redirectRoute('login');

        $this->setApiResponse(fn() => response()->json(['message' => 'done'], 200));

        return $this->response();
    }

    /**
     * @return mixed
     */
    public function forgetPassword()
    {
        $this->setData('title', __('main.forget_password'), 'web');

        $this->addView('users::user.auth.forgot-password');

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    public function showLinkRequestForm()
    {
        return view("{$this->domainAlias}::{$this->viewPath}.auth.forgot-password", [
            'title' => 'Forget Password',
        ]);
    }

    /**
     * @param UserForgetPasswordFormRequest $request
     * @return mixed
     */
    public function store(UserForgotPasswordFormRequest $request)
    {
        $user = $this->userRepository->whereEmail($request->validated())->firstOrFail();
        Mail::to($user->email)->send(
            new ResetPassword(
                $user,
                $this->reminders->hasOrCreateToken($user, 'reminder')
            )
        );
        $this->setData('message', __('main.reset password mail sent'));
        $this->redirectRoute('login');

        $this->setApiResponse(fn() => response()->json(['data' => [
            'message' => 'Check your mail, we have sent you a reset token.',
        ]], 200));

        return $this->response();
    }
}
