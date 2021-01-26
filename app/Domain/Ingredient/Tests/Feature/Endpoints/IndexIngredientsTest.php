<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Ingredient\Entities\Ingredient;

class IndexIngredientsTest extends TestCase
{
    /** @test */
    public function it_should_filter_ingredients_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->ingredientFactory->count(5)->create();
        $this->ingredientFactory->create([
            'name' => $name = 'hello',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.ingredients.index'), 'filter[name]', $name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($name, $response->getData(true)['data'][0]['name']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_ingredients_sort_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_ingredients_sort_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->ingredientFactory->withStatus('active')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /**  @test */
    public function it_should_list_all_of_active_ingredients_paginated_by_default()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->ingredientFactory->count(5)->withStatus('active')->create();
        $this->ingredientFactory->withStatus('inactive')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_return_ingredients_with_products_included()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ingredients = $this->ingredientFactory->withStatus('active')->withProducts(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.index') . '?include=products'
        )->assertJsonStructure([
            'data' => [
                [
                    'products' => [
                        [
                            'id',
                            'name',
                            'price',
                            'stock_count',
                        ],
                    ],

                ],
            ],
        ]);
        $this->assertTrue(array_key_exists('products', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_return_ingredients_with_user_included()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ingredients = $this->ingredientFactory->withStatus('active')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->ingredientFactory = Ingredient::factory();
    }
}
