<?php

namespace App\Domain\Location\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class StoreLocationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_create_location_with_existing_parent()
    {
        $parentLocation = $this->locationFactory->create();
        $location = $this->locationFactory->make([
            'name' => 'hello',
            'parent_id' => $parentLocation->id,
        ]);
        config(['app.locale' => 'ar']);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'POST',
            route('api.locations.store'), array_merge($location->toArray(), [
                'name_ar' => $name = 'الاسم بالعربي',
            ])
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at_human',

            ],
        ]);
        $this->assertEquals($name, $response->getData(true)['data']['name']);
    }

    /** @test */
    public function it_should_store_location_if_name_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.locations.store'), [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'zone',
            ]
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at_human',

            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_create_location_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.locations.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_create_location_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.locations.store'), [
                'name' => 'hello',
                'type' => 'speciality',
                'parent_id' => 1,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_store_location_if_name_of_location_already_existing()
    {
        $location = $this->locationFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.locations.store'), [
                'name' => $location->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_location_if_unauthenticated()
    {
        $this->post(
            route('api.locations.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}
