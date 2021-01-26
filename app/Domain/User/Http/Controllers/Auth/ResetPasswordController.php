<?php

namespace App\Domain\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\PasswordReset;
use App\Domain\User\Repositories\Contracts\RemindableRepository;
use App\Domain\User\Repositories\Contracts\PasswordResetRepository;
use App\Domain\User\Http\Requests\Auth\UserResetPasswordFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class ResetPasswordController extends Controller
{
    use Responder;

    /**
     * @var mixed
     */
    protected $reminders;

    /**
     * @param PasswordResetRepository $passwordReset
     */
    public function __construct(RemindableRepository $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function resetPassword($token)
    {
        $validToken = $this->passwordReset->where('token', $token)->value('token');
        if (isset($validToken) && !is_null($validToken)) {
            $this->setData('title', __('main.reset_password'), 'web');
            $this->addView('users::user.auth.reset-form');
        } else {
            $this->redirectRoute('login');
        }

        $this->setApiResponse(function () {
            return response()->json(['create_your_own_form' => true]);
        });

        return $this->response();
    }

    /**
     * @param User $user
     * @param null $token
     * @param null ResetUserPasswordFormRequest $request
     */
    public function update(UserResetPasswordFormRequest $request, $token)
    {
        $user = $this->passwordReset->where(['token' => $token, 'status' => 'active'])->first()->user ?? null;
        if ($user && $this->passwordReset->complete($user, $token)) {
            User::withoutEvents(function () use ($request, $user) {
                $user->password = bcrypt($request->validated()['password']);
                $user->save();
            });
            $this->redirectRoute('login');
            $this->setApiResponse(fn() => response()->json(['message' => 'done'], 200));
        } else {
            $this->setApiResponse(fn() => response()->json(['message' => __('main.invalid token')], 404));
        }

        return $this->response();
    }
}
