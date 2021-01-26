<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariation;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;

class StoreProductVariationTest extends TestCase
{
    /** @test */
    public function it_should_create_product_variation()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->make([
            'product-variation-images' => [UploadedFile::fake()->image('image.jpg')],
            'user_id' => User::factory()->create()->id,

        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.product_variations.store'), ['price' => 100] + $product->toArray()
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'price_varies',
                'price',
                'status',
                'stock_count',
                'in_stock',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_product_variation_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.product_variations.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_product_variation_if_unauthenticated()
    {
        $this->post(
            route('api.product_variations.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
    }
}
