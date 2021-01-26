<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class DestroyWishlistTest extends TestCase
{
    /** @test */
    public function it_deletes_an_item_from_the_wishlist()
    {
        $user = User::factory()->create();
        $user->wishlist()->sync(
            $product = ProductVariation::factory()->create()
        );
        $this->jsonAs($user->fresh(), 'DELETE', "api/wishlist/{$product->id}");
        $this->assertDatabaseMissing('user_wishlist', [
            'product_variation_id' => $product->id,
        ]);
    }

    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->delete('/api/wishlist/1')->assertStatus(401);
    }
}
