<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class DestroyCartTest extends TestCase
{
    /** @test */
    public function it_deletes_an_item_from_the_cart()
    {
        $user = User::factory()->create();
        $user->cart()->sync(
            $product = ProductVariation::factory()->create()
        );
        $this->jsonAs($user->fresh(), 'DELETE', "api/cart/{$product->id}");
        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id,
        ]);
    }

    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->delete('/api/cart/1')->assertStatus(401);
    }
}
