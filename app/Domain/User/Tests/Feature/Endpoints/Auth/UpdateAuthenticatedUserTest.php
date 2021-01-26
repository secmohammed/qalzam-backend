<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Resources\User\UserResource;

class UpdateAuthenticatedUserTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_himself_if_authenticated_and_data_is_valid()
    {
        $user = $this->userFactory->create();
        $response = $this->jsonAs(
            $user,
            'PUT',
            route('api.auth.me'), [
                'mobile' => $mobile = '01067123849',

            ] + $user->toArray()
        )->assertStatus(200);
        $user->mobile = $mobile;
        $userResource = new UserResource($user->fresh());
        $response->assertResource($userResource);

    }

    /** @test */
    public function it_should_make_sure_that_file_is_attached_and_moved_successfully_and_returned_in_the_resource()
    {
        \Storage::fake();
        $user = $this->userFactory->create();
        $response = $this->jsonAs(
            $user,
            'PUT',
            route('api.auth.me'), [
                'mobile' => '01067123849',
                'avatar' => UploadedFile::fake()->create('avatar.png', 30),
                'national_id' => '20102010112345',
            ] + $user->toArray()
        )->assertStatus(200);
        $user->avatar = $response->json()['data']['avatar'];
        $userResource = new UserResource($user->fresh());
        $response->assertResource($userResource);
        $this->assertNotEmpty($user->avatar);
    }

    /** @test */
    public function it_shouldnt_let_user_update_himself_if_not_authenticated()
    {
        $this->put(
            route('api.auth.me'), []
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_update_if_data_is_invalid()
    {
        $user = $this->userFactory->create();
        $response = $this->jsonAs(
            $user,
            'PUT',
            route('api.auth.me'), [
                'mobile' => '01113azx',
            ] + $user->toArray()
        )->assertStatus(422)->assertJsonValidationErrors([
            'mobile',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
    }
}
