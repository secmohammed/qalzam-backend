<?php

namespace App\Domain\User\Tests\Feature\Endpoints\User;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class StoreUserTest extends TestCase
{
    /** @test */
    public function it_should_create_user()
    {
        $authUser = $this->userFactory->create();

        config(['app.locale' => 'ar']);

        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());
        $user = $this->userFactory->make([
            'image' => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response = $this->jsonAs($authUser, 'POST',
            route('api.users.store'), $user->toArray() + [
                'name_ar' => $name = 'الاسم بالعربي',
                'password' => $password = Str::random(10),
                'password_confirmation' => $password,
                'image' => [UploadedFile::fake()->image('image.png')],
                'role_id' => Role::latest()->first()->id,
            ]
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_user_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.users.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_user_if_email_of_user_already_existing()
    {
        $user = $this->userFactory->create([
            'email' => 'ex@email.com',
        ]);

        $authUser = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());
        $this->jsonAs($authUser, 'POST',
            route('api.users.store'), [
                'email' => $user->email,
            ]
        )->assertStatus(422)->assertJsonValidationErrors([
            'email',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_user_if_mobile_of_user_already_existing()
    {
        $user = $this->userFactory->create([
            'mobile' => '01124713876',
        ]);

        $authUser = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());
        $this->jsonAs($authUser, 'POST',
            route('api.users.store'), [
                'mobile' => $user->mobile,
            ]
        )->assertStatus(422)->assertJsonValidationErrors([
            'mobile',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_user_if_unauthenticated()
    {
        $this->post(
            route('api.users.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
    }
}
