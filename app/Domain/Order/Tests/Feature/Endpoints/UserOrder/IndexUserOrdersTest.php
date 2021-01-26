<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\UserOrder;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Category\Entities\Category;

class IndexUserOrdersTest extends TestCase
{
    /** @test */
    public function it_should_fetch_products_with_categories()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->count(3)->withCategory(3, [
            'status' => 'active',
        ])->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?include=categories'
        );
        $this->assertTrue(array_key_exists('categories', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['categories']);
    }

    /** @test */
    public function it_should_fetch_products_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_filter_products_by_categories_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->withCategory()->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[categories.id]=' . Category::first()->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_products_by_categories_ids()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->withCategory()->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[categories.ids]=' . implode(',', Category::pluck('id')->toArray())
        );
        $this->assertCount(3, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_products_by_cateogry_or_product_name()
    {
        $products = $this->productFactory->withStatus('active')->count(5)
            ->create();
        $category = $this->categoryFactory->withProductType()->withStatus('active')->create();
        $otherCategory = $this->categoryFactory->withProductType()->withStatus('active')->create();
        $products->each(function ($product) use ($category) {
            $product->categories()->save($category);
        });
        $otherProducts = $this->productFactory->withStatus('active')->count(5)->withCategory()->create();
        $otherProducts->each(function ($product) use ($otherCategory) {
            $product->categories()->save($otherCategory);
        });
        $response = $this->get(
            route('api.products.index') . '?filter[by_name_or_category]=' . $products->first()->categories->first()->name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(5, $response->getData(true)['data']);
        $response = $this->get(
            route('api.products.index') . '?filter[by_name_or_category]=' . $products->first()->name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_products_by_price_range()
    {
        $this->productFactory->withStatus('active')->count(5)->create([
            'price' => $this->faker->numberBetween(150, 200),
        ]);
        $this->productFactory->withStatus('active')->create([
            'price' => $this->faker->numberBetween(300, 400),
        ]);
        $response = $this->get(
            route('api.products.index') . '?filter[price_between]=100,200'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(5, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_products_by_user_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->withCategory()->withStatus('active')->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[user.id]=' . Product::first()->user->id
        );
        $this->assertCount(1, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_let_user_filter_products_by_description()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productFactory->count(2)->create([
            'description' => $description = 'description',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[description]=' . $description
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_products_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productFactory->create([
            'name' => $name = 'mohammed',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[name]=' . $name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_products_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->productFactory->count(2)->create([
            'status' => 'inactive',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?filter[status]=active'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_products_paginated_by_default()
    {
        $this->productFactory->count(5)->withStatus('active')->create();
        $this->productFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.products.index')
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

        $this->productFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_products_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->productFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->productFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_products_by_prices_asc()
    {
        $this->productFactory->withStatus('active')->create([
            'price' => 100,
        ]);
        $this->productFactory->withStatus('active')->create([
            'price' => 200,
        ]);
        $this->productFactory->withStatus('active')->create([
            'price' => 150,
        ]);
        $response = $this->get(
            route('api.products.index') . '?filter[sort_price]=asc'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            '١٫٠٠ ج.م.‏',
            $response->getData(true)['data'][0]['price']
        );

    }

    /** @test */
    public function it_should_sort_products_by_prices_desc()
    {
        $this->productFactory->withStatus('active')->create([
            'price' => 100,
        ]);
        $this->productFactory->withStatus('active')->create([
            'price' => 200,
        ]);
        $this->productFactory->withStatus('active')->create([
            'price' => 150,
        ]);
        $response = $this->get(
            route('api.products.index') . '?filter[sort_price]=desc'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            '٢٫٠٠ ج.م.‏',
            $response->getData(true)['data'][0]['price']
        );

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productFactory = Product::factory();
        $this->faker = Factory::create();

        $this->categoryFactory = Category::factory();

    }
}
