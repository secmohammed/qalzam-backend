<?php
namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class RefreshJWTTokenController extends Controller
{
    /**
     * @param UserUpdateProfileFormRequest $request
     */
    public function update()
    {
        auth()->refresh();

        return (new UserResource(auth()->user()))->additional([
            'meta' => [
                'token' => auth()->user()->generateAuthToken(),
            ],
        ]);
    }
}
