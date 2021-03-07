<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Contract;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Entities\Accommodation;

class IndexContractsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_contracts_with_template_when_available()
    {
        $this->contractFactory->create([
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.contracts.index') . '?include=template'
        );
        $this->assertTrue(array_key_exists('template', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_contracts_with_user_when_available()
    {
        $this->contractFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.contracts.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_contracts_by_days()
    {
        $this->contractFactory->create([
            'status' => 'active',

            'days' => [
                'monday', 'tuesday', 'friday',
            ],
        ]);
        $this->contractFactory->create([
            'status' => 'active',

            'days' => [
                'friday', 'wednesday',
            ],
        ]);
        $this->contractFactory->create([
            'status' => 'active',
            'days' => [
                'friday', 'monday',
            ],
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.contracts.index'), 'filter[containing_days]', 'friday,monday')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

        $this->assertEquals(2, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_contracts_by_name()
    {
        $contracts = $this->contractFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.contracts.index'), 'filter[name]', $contracts->first()->name)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_contracts_by_template_id()
    {
        $this->contractFactory->count(5)->create();
        $contract = $this->contractFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.contracts.index'), 'filter[template.id]', $contract->template_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($contract->template_id, $response->getData(true)['data'][0]['template_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_contracts_by_user_id()
    {
        $this->contractFactory->count(5)->create();
        $contract = $this->contractFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.contracts.index'), 'filter[user.id]', $contract->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($contract->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->contractFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->contractFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->contractFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.contracts.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_by_created_at_descending()
    {
        $this->contractFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->contractFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->contractFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.contracts.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->contractFactory = Contract::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}
