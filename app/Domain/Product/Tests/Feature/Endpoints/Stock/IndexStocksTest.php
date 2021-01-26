<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Stock;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class IndexStocksTest extends TestCase
{
    /** @test */
    public function it_should_fetch_stocks_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->stockFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_filter_stocks_by_product_variation_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $stocks = $this->stockFactory->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?filter[variation.id]=' . $stocks->first()->variation->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_stocks_by_user_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->stockFactory->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?filter[user.id]=' . Stock::first()->user->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_let_user_filter_stocks_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->stockFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->stockFactory->count(2)->create([
            'status' => 'inactive',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?filter[status]=active'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_stocks_paginated_by_default()
    {
        $this->stockFactory->count(5)->withStatus('active')->create();
        $this->stockFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.stocks.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_sort_stocks_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->stockFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->stockFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->stockFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_stocks_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->stockFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->stockFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->stockFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.index') . '?sort=-created_at'
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
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();
        $this->faker = Factory::create();
        $this->productFactory = Product::factory();

    }
}
