<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class DestroyCartTest extends TestCase
{
    /** @test */
    public function it_deletes_an_item_from_the_cart()
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();
        $product = ProductVariation::factory()->create();
        $branch->products()->attach($product);
        $user->cart()->sync(
            [$product->id => [
                'branch_id' => $branch->id,
                'type' => 'cart',
            ]]
        );
        $this->jsonAs($user->fresh(), 'DELETE', route('api.auth.cart.destroy', [
            'productVariation' => $product->id,
            'branch' => $branch->id,

        ]))->assertStatus(200);
        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id,
            'type' => 'cart',
        ]);
    }

    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $branch = Branch::factory()->create();

        $this->delete(route('api.auth.cart.destroy', [
            'productVariation' => 1,
            'branch' => $branch->id,

        ]))->assertStatus(401);
    }
}
