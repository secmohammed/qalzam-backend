<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariationType;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariationType;

class UpdateProductVariationTypeTest extends TestCase
{
    /** @test */
    public function it_should_update_product_variation_type()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product_variation = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.product_variation_types.update', $product_variation->id), $product_variation->toArray()
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_product_variation_type_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'PUT',
            route('api.product_variation_types.update', 100000), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_product_variation_type_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $product_variation = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs($user, 'PUT',
            route('api.product_variation_types.update', $product_variation->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_product_variation_type_if_unauthenticated()
    {
        $product_variation = $this->productVariationTypeFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.product_variation_types.update', $product_variation->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationTypeFactory = ProductVariationType::factory();
    }
}
