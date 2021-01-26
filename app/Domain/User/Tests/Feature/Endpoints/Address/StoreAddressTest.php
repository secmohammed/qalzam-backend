<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Address;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class StoreAddressTest extends TestCase
{
    /** @test */
    public function it_should_create_address()
    {
        $authUser = $this->userFactory->create();
        $address = $this->addressFactory->make([
            'status' => 'active',
        ]);

        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());

        $response = $this->jsonAs($authUser, 'POST',
            route('api.addresses.store'), $address->toArray() + [
            ]
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address_1',
                'postal_code',
                'default',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_address_if_doesnt_have_permission()
    {
        $address = $this->addressFactory->make([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.addresses.store'), $address->toArray()
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_address_if_location_id_doesnt_exist()
    {
        $address = $this->addressFactory->make([
            'status' => 'active',
            'location_id' => 1000,
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.addresses.store'), $address->toArray()
        )->assertStatus(422)->assertJsonValidationErrors([
            'location_id',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_address_if_unauthenticated()
    {
        $this->post(
            route('api.addresses.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->addressFactory = Address::factory();
    }
}
