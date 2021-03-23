<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariation;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;

class IndexProductVariationsTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_fetch_product_variations_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?include=user'
        );

        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /**
     * @test
     */
    public function it_should_filter_product_variations_by_price_range()
    {
        $this->productVariationFactory->withStatus('active')->count(5)->create([
            'price' => $this->faker->numberBetween(150, 200),
        ]);
        $this->productVariationFactory->withStatus('active')->create([
            'price' => $this->faker->numberBetween(300, 400),
        ]);
        $response = $this->get(
            route('api.product_variations.index') . '?filter[price_between]=100,200'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(5, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_filter_product_variations_by_user_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[user.id]=' . ProductVariation::first()->user->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /**
     * @test
     */
    public function it_should_let_user_filter_product_variations_by_details_criteria()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
            'details' => [
                'color' => 'red',

            ],
        ]);
        $product = $this->productVariationFactory->create([
            'status' => 'active',
            'details' => [
                'color' => 'blue',
            ],
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[criteria][color]=blue'
        );
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_let_user_filter_product_variations_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productVariationFactory->create([
            'name' => $name = 'mohammed',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[name]=' . $name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_let_user_filter_product_variations_by_product_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productVariationFactory->count(2)->create([
            'product_id' => $product->id,
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[product.id]=' . $product->id
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_let_user_filter_product_variations_by_product_variation_type_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $productVariationType = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productVariationFactory->count(2)->create([
            'product_variation_type_id' => $productVariationType->id,
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[type.id]=' . $productVariationType->id
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_let_user_filter_product_variations_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productVariationFactory->count(2)->create([
            'status' => 'inactive',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?filter[status]=active'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**
     * @test
     */
    public function it_should_list_all_of_active_product_variations_paginated_by_default()
    {
        $this->productVariationFactory->count(5)->withStatus('active')->create();
        $this->productVariationFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.product_variations.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /**
     * @test
     */
    public function it_should_sort_product_variations_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /**
     * @test
     */
    public function it_should_sort_product_variations_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productVariationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productVariationFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /**
     * @test
     */
    public function it_should_sort_product_variations_by_prices_asc()
    {
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 100,
        ]);
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 200,
        ]);
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 150,
        ]);
        $response = $this->get(
            route('api.product_variations.index') . '?filter[sort_price]=asc'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            '١٠٠٫٠٠ ر.س.‏',
            $response->getData(true)['data'][0]['price']
        );

    }

    /**
     * @test
     */
    public function it_should_sort_product_variations_by_prices_desc()
    {
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 100,
        ]);
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 200,
        ]);
        $this->productVariationFactory->withStatus('active')->create([
            'price' => 150,
        ]);
        $response = $this->get(
            route('api.product_variations.index') . '?filter[sort_price]=desc'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            '٢٠٠٫٠٠ ر.س.‏',
            $response->getData(true)['data'][0]['price']
        );

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->productVariationTypeFactory = ProductVariationType::factory();
        $this->faker = Factory::create();
        $this->productFactory = Product::factory();

    }
}
