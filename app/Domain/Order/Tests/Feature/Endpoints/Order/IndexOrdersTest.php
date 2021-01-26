<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Category\Entities\Category;
use App\Domain\Product\Entities\ProductVariation;

class IndexOrdersTest extends TestCase
{
    /** @test */
    public function it_should_fetch_orders_with_products()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $order = $this->orderFactory->create([
            'status' => 'pending',
        ]);
        $products = ProductVariation::factory()->count(3)->create([
            'status' => 'active',
        ]);
        $order->products()->attach($products, ['quantity' => 1]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?include=products'
        );
        $this->assertTrue(array_key_exists('products', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['products']);
    }

    /** @test */
    public function it_should_fetch_products_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_filter_orders_by_user_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?filter[user.id]=' . Order::first()->user->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_products_by_address_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->count(1)->create([
            'address_id' => $id = $this->addressFactory->create()->id,
        ]);
        $this->orderFactory->count(3)->create([
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?filter[address.id]=' . $id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_let_user_filter_orders_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->count(3)->create([
            'status' => 'pending',
        ]);
        $this->orderFactory->count(2)->create([
            'status' => 'delivered',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?filter[status]=pending'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_orders_paginated_by_default()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->count(5)->withStatus('pending')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_sort_products_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->orderFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->orderFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDateTimeString(),
            $response->getData(true)['data'][0]['created_at']
        );
    }

    /** @test */
    public function it_should_sort_products_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->orderFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->orderFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->orderFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'pending',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDateTimeString(),
            $response->getData(true)['data'][0]['created_at']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
        $this->addressFactory = Address::factory();
        $this->faker = Factory::create();

        $this->categoryFactory = Category::factory();

    }
}
