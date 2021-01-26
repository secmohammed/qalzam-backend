<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Product;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class ShowProductTest extends TestCase
{
    /** @test */
    public function it_should_let_user_see_product_if_not_authenticated()
    {
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.products.show', $product)
        )->assertStatus(200);
    }

    /** @test */
    public function it_should_see_product_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'price',
                'status',
                'images',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_product_with_his_categories_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->withCategory()->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product) . '?include=categories'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'categories',
            ],
        ]);

    }

    /** @test */
    public function it_should_see_product_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_should_see_product_with_his_variations_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->withVariation()->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product) . '?include=variations'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'variations',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_see_product_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_product_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $product = $this->productFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.products.show', $product)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productFactory = Product::factory();

    }
}
