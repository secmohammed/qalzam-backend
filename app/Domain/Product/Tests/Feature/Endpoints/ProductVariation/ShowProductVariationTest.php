<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariation;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;

class ShowProductVariationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_see_product_variation_if_not_authenticated()
    {
        $product = $this->productVariationFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.product_variations.show', $product)
        )->assertStatus(200);
    }

    /** @test */
    public function it_should_see_product_variation_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.show', $product)
        )->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'price',
                'in_stock',
                'stock_count',
                'price_varies',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_product_variation_with_his_product_variation_type_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->create([
            'status' => 'active',
            'product_variation_type_id' => ProductVariationType::factory()->create()->id,
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.show', $product) . '?include=type'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'type',
            ],
        ]);

    }

    /** @test */
    public function it_should_see_product_variation_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.show', $product) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_product_variation_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.show', $product)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_product_variation_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $product = $this->productVariationFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variations.show', $product)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();

    }
}
