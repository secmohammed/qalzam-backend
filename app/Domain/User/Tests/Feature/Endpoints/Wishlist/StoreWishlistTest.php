<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class StoreWishlistTest extends TestCase
{
    /** @test */
    public function it_can_add_products_to_the_users_wishlist()
    {
        $user = $this->userFactory->create();
        $product = $this->productVariationFactory->create();
        $this->branch->products()->attach($product);
        $response = $this->jsonAs($user, 'POST', route('api.auth.wishlist.store', $this->branch->id), [
            'products' => [
                ['id' => $product->id],
            ],
        ]);
        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'type' => 'wishlist',
            'branch_id' => $this->branch->id,
        ]);
    }

    /** @test */
    public function it_fails_if_user_is_unauthenticated()
    {
        $this->post(route('api.auth.wishlist.store', $this->branch->id))->assertStatus(401);
    }

    /** @test */
    public function it_requires_products()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', route('api.auth.wishlist.store', $this->branch->id))
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_an_array()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', route('api.auth.wishlist.store', $this->branch->id), [
            'products' => 1,
        ])
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_have_an_id()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', route('api.auth.wishlist.store', $this->branch->id), [
            'products' => [
                [],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    /** @test */
    public function it_requires_products_to_exist()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', route('api.auth.wishlist.store', $this->branch->id), [
            'products' => [
                ['id' => 1],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->branchFactory = Branch::factory();
        $this->branch = $this->branchFactory->create();

    }
}
