<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class StoreWishlistTest extends TestCase
{
    /** @test */
    public function it_can_add_products_to_the_users_wishlist()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create();
        $response = $this->jsonAs($user, 'POST', '/api/wishlist', [
            'products' => [
                'id' => $product->id,
            ],
        ]);
        $this->assertDatabaseHas('user_wishlist', [
            'product_variation_id' => $product->id,
        ]);
    }

    /** @test */
    public function it_fails_if_user_is_unauthenticated()
    {
        $this->post('/api/wishlist')->assertStatus(401);
    }

    /** @test */
    public function it_requires_products()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', '/api/wishlist')
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_an_array()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', '/api/wishlist', [
            'products' => 1,
        ])
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_have_an_id()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', '/api/wishlist', [
            'products' => [
                [],
            ],
        ])
            ->assertJsonValidationErrors(['products.0']);
    }

    /** @test */
    public function it_requires_products_to_exist()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'POST', '/api/wishlist', [
            'products' => [
                ['id' => 1],
            ],
        ])
            ->assertJsonValidationErrors(['products.0']);
    }
}
