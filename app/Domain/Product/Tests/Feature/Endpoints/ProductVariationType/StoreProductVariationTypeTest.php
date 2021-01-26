<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariationType;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariationType;

class StoreProductVariationTypeTest extends TestCase
{
    /** @test */
    public function it_should_create_product_variation_type()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationTypeFactory->make([
            'user_id' => User::factory()->create()->id,

        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.product_variation_types.store'), $product->toArray()
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_product_variation_type_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.product_variation_types.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_product_variation_type_if_unauthenticated()
    {
        $this->post(
            route('api.product_variation_types.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationTypeFactory = ProductVariationType::factory();
    }
}
