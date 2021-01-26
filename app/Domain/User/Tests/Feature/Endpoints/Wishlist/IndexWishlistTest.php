<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class IndexWishlistTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->get('/api/wishlist')->assertStatus(401);
    }

    /** @test */
    public function it_shows_products_in_the_user_wishlist()
    {
        $user = User::factory()->create();

        $user->wishlist()->sync(
            $product = ProductVariation::factory()->create()
        );

        $this->jsonAs($user, 'GET', 'api/wishlist')->assertJsonFragment([
            'id' => $product->id,
        ]);
    }
}
