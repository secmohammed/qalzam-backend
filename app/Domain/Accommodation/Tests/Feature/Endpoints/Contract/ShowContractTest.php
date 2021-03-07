<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Contract;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Entities\Accommodation;

class ShowContractTest extends TestCase
{
    /** @test */
    public function it_should_fetch_contract_by_id_if_authenticated_and_has_permissions()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.contracts.show', $contract->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'name',
                'id',
                'days',
                'template_id',
                'user_id',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_should_return_days_as_array()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.contracts.show', $contract->id)
        )->assertStatus(200);
        $this->assertTrue(is_array($response->getData(true)['data']['days']));

    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.contracts.show', $contract->id)
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_fetch_contract_by_id_if_not_found()
    {
        $this->get(
            route('api.contracts.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_contract_if_not_authenticated()
    {
        $contract = $this->contractFactory->create();
        $this->get(
            route('api.contracts.show', $contract->id)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->contractFactory = Contract::factory();
        $this->userFactory = User::factory();
    }
}
