<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariationType;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariationType;

class ShowProductVariationTypeTest extends TestCase
{
    /** @test */
    public function it_should_let_user_see_product_variation_type_if_not_authenticated()
    {
        $product = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.product_variation_types.show', $product)
        )->assertStatus(200);
    }

    /** @test */
    public function it_should_see_product_variation_type_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.show', $product)
        )->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at_human',
                'status',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_product_variation_type_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.show', $product) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_product_variation_type_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationTypeFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.show', $product)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_product_variation_type_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $product = $this->productVariationTypeFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.product_variation_types.show', $product)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationTypeFactory = ProductVariationType::factory();

    }
}
