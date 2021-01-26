<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariationType;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;

class IndexProductVariationTypesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_product_variation_types_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_filter_product_variation_types_by_user_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?filter[user.id]=' . ProductVariationType::first()->user->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_let_user_filter_product_variation_types_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->count(3)->create([
            'status' => 'active',
        ]);
        $productVariationType = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?filter[name]=' . $productVariationType->name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_product_variation_types_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productVariationTypeFactory->count(2)->create([
            'status' => 'inactive',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?filter[status]=active'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_product_variation_types_paginated_by_default()
    {
        $this->productVariationTypeFactory->count(5)->withStatus('active')->create();
        $this->productVariationTypeFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.product_variation_types.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_sort_product_variation_types_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationTypeFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationTypeFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_product_variation_types_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationTypeFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationTypeFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationTypeFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.index') . '?sort=-created_at'
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
        $this->productVariationTypeFactory = ProductVariation::factory();
        $this->productVariationTypeFactory = ProductVariationType::factory();
        $this->faker = Factory::create();
        $this->productFactory = Product::factory();

    }
}
