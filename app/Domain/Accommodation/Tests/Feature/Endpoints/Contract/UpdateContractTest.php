<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Contract;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Entities\Accommodation;

class UpdateContractTest extends TestCase
{
    /** @test */
    public function it_should_update_contract()
    {
        \Storage::fake('local');
        $contract = $this->contractFactory->create([
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.contracts.update', $contract->id), $contract->toArray() + [
            ]
        )->assertStatus(200)->assertJsonStructure(['data']);
    }

    /** @test */
    public function it_shouldnt_let_user_update_contract_if_doesnt_exist()
    {
        $this->put(
            route('api.contracts.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_contract_if_doesnt_have_permission()
    {
        $contract = $this->contractFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.contracts.update', $contract->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_contract_if_name_already_exists()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $anotherAccommodation = $this->contractFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.contracts.update', $anotherAccommodation->id), ['name' => $contract->name] + $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_update_contract_if_unauthenticated()
    {
        $contract = $this->contractFactory->create();
        $this->put(
            route('api.contracts.update', $contract->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->contractFactory = Contract::factory();
    }
}
