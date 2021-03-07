<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Contract;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;
use App\Domain\Accommodation\Entities\Contract;

class DestroyContractTest extends TestCase
{
    /** @test */
    public function it_should_delete_contract_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $contract = $this->contractFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.contracts.destroy', $contract->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_delete_contract_when_template_is_deleted()
    {
        $user = $this->userFactory->create();
        $contract = $this->contractFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        Template::whereId($contract->template_id)->delete();
        $this->assertDatabaseMissing('contracts', [
            'id' => $contract->id,
            'name' => $contract->name,
        ]);
    }

    /** @test */
    public function it_shouldnt_destroy_contract_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.contracts.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_contract_if_not_having_permission_of_deleting_contract()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.contracts.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_contract_if_unauthenticated()
    {
        $this->delete(
            route('api.contracts.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->contractFactory = Contract::factory();
    }
}
