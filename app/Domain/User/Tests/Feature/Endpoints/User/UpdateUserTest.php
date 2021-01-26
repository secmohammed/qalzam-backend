<?php

namespace App\Domain\User\Tests\Feature\Endpoints\User;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdateUserTest extends TestCase
{
    /** @test */
    public function it_should_update_user()
    {
        $authUser = $this->userFactory->create();

        config(['app.locale' => 'ar']);

        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());
        $user = $this->userFactory->create();
        $response = $this->jsonAs($authUser, 'PUT',
            route('api.users.update', $user), $user->toArray() + [
                'name_ar' => $name = 'الاسم بالعربي',
                'password' => $password = Str::random(10),
                'password_confirmation' => $password,
                'role_id' => Role::latest()->first()->id,

            ]
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_user_if_doesnt_exist()
    {
        $this->put(
            route('api.users.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_user_if_doesnt_have_permission()
    {
        $authUser = $this->userFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($authUser, 'PUT',
            route('api.users.update', $user->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_user_if_email_of_user_already_existing()
    {
        $user = $this->userFactory->create([
            'email' => 'ex@email.com',
        ]);
        $anotherUser = $this->userFactory->create();

        $authUser = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());
        $this->jsonAs($authUser, 'PUT',
            route('api.users.update', $user), array_merge($user->toArray(), [
                'email' => $anotherUser->email,
                'name_ar' => 'oqwdo',
            ])
        )->assertStatus(422)->assertJsonValidationErrors([
            'email',
        ]);
    }

    /** @test */
    public function it_shouldnt_update_user_if_unauthenticated()
    {
        $user = $this->userFactory->create();
        $this->put(
            route('api.users.update', $user->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
    }
}
