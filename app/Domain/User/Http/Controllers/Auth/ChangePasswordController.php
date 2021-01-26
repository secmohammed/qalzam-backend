<?php

namespace App\Domain\User\Http\Controllers\Auth;

use Joovlly\DDD\Traits\Responder;
use App\Domain\User\Http\Requests\Auth\UserChangePasswordFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class ChangePasswordController extends Controller
{
    use Responder;

    /**
     * @param UserChangePasswordFormRequest $request
     */
    public function update(UserChangePasswordFormRequest $request)
    {
        if (\Hash::check($request->old_password, auth()->user()->password)) {
            auth()->user()->update(
                $request->only('password')
            );
            $this->redirectRoute('login');
            $this->setApiResponse(fn() => response()->json(['message' => 'done'], 200));

            return $this->response();
        }
        $this->setApiResponse(fn() => response()->json(['message' => 'invalid-token'], 406));
        $this->redirectRoute('login');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePasswordForm()
    {
        $this->setData('title', __('main.change_password'), 'web');
        $this->addView('users::user.auth.change_password');
        $this->setApiResponse(fn () => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }
}
