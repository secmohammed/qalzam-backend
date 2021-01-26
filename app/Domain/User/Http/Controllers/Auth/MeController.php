<?php

namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Requests\Auth\UserUpdateProfileFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class MeController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user()->load('children'));
    }

    /**
     * @param UserUpdateProfileFormRequest $request
     */
    public function update(UserUpdateProfileFormRequest $request)
    {
        auth()->user()->update($request->validated());
        if ($request->has('avatar')) {
            if (auth()->user()->hasMedia('avatar')) {
                auth()->user()->clearMediaCollection('avatar');
            }
            auth()->user()->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return new UserResource(auth()->user()->fresh());
    }
}
