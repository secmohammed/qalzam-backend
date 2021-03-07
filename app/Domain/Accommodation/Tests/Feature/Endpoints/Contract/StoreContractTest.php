<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Contract;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Entities\Accommodation;

class StoreContractTest extends TestCase
{
    /** @test */
    public function it_should_create_contract()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $contract = $this->contractFactory->make([
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.contracts.store'), $contract->toArray() + [
            ]
        )->assertStatus(201)->assertJsonStructure([
            'data',
        ]);
    }

    /** @test */
    public function it_shouldnt_create_contract_if_name_already_exists()
    {
        $contract = $this->contractFactory->create();
        $user = $this->userFactory->create();
        $anotherAccommodation = $this->contractFactory->make([

            'type' => 'table',
            'name' => $contract->name,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.contracts.store'), $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_create_contract_if_the_passed_template_id_doesnt_have_products_attached()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $template = $this->templateFactory->create();
        $contract = $this->contractFactory->make([
            'template_id' => $template->id,
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.contracts.store'), $contract->toArray() + [
            ]
        )->assertJsonValidationErrors(['template_id']);

    }

    /** @test */
    public function it_shouldnt_let_user_create_contract_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.contracts.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_pass_if_array_of_days_contains_an_invalid_day_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $contract = $this->contractFactory->make([
            'days' => [
                'hello',
            ],
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.contracts.store'), $contract->toArray() + [
            ]
        )->assertJsonValidationErrors(['days.0']);

    }

    /** @test */
    public function it_shouldnt_pass_if_days_arent_array()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $contract = $this->contractFactory->make([
            'days' => 'hello',
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.contracts.store'), $contract->toArray() + [
            ]
        )->assertJsonValidationErrors(['days']);

    }

    /** @test */
    public function it_shouldnt_store_contract_if_unauthenticated()
    {
        $this->post(
            route('api.contracts.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->contractFactory = Contract::factory();
        $this->templateFactory = Template::factory();
    }
}
