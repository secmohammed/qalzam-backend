<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Address;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdateAddressTest extends TestCase
{
    /** @test */
    public function it_sets_old_addresses_to_not_default_while_creating()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $oldAddress = $this->addressFactory->create([
            'user_id' => $user->id,
            'default' => true,
        ]);
        $address = $this->addressFactory->create([
            'default' => true,
            'user_id' => $user->id,
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.addresses.update', $address), $address->toArray()
        );
        $this->assertFalse(!!$oldAddress->fresh()->default);

    }

    /** @test */
    public function it_should_update_address()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addressFactory->create();
        $response = $this->jsonAs($user, 'PUT',
            route('api.addresses.update', $address), $address->toArray()
        )->assertStatus(200)->assertJsonStructure([
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
    public function it_shouldnt_let_user_update_address_if_doesnt_exist()
    {
        $this->put(
            route('api.addresses.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_address_if_doesnt_have_permission()
    {
        $authUser = $this->userFactory->create();

        $address = $this->addressFactory->create();
        $this->jsonAs($authUser, 'PUT',
            route('api.addresses.update', $address->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_address_if_unauthenticated()
    {
        $address = $this->addressFactory->create();
        $this->put(
            route('api.addresses.update', $address->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->addressFactory = Address::factory();
    }
}
