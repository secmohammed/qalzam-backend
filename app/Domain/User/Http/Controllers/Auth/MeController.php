<?php

namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Requests\Auth\UserUpdateProfileFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class MeController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user());
    }

    /**
     * @param UserUpdateProfileFormRequest $request
     */
    public function update(UserUpdateProfileFormRequest $request)
    {
        auth()->user()->update($request->validated());
        if ($request->has('image')) {
            if (auth()->user()->hasMedia('image')) {
                auth()->user()->clearMediaCollection('image');
            }
            auth()->user()->addMedia($request->file('image'))->toMediaCollection('image');
        }

        return new UserResource(auth()->user()->fresh());
    }
}
