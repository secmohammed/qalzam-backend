<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Address;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyAddressTest extends TestCase
{
    /** @test */
    public function it_should_delete_an_address_when_having_permissions_and_address_exists()
    {
        $authUser = $this->userFactory->create();
        $address = $this->addressFactory->count(2)->create([
            'status' => 'active',
            'user_id' => $authUser->id,
        ]);
        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());

        $this->jsonAs($authUser, 'DELETE',
            route('api.addresses.destroy', $address->first())
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_address_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.addresses.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_address_if_not_having_permission_of_deleting_address()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.addresses.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_address_if_unauthenticated()
    {
        $address = $this->addressFactory->create([
            'status' => 'active',
        ]);
        $this->delete(
            route('api.addresses.destroy', $address->id)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->addressFactory = Address::factory();
    }
}
