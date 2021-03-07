<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class DestroyWishlistTest extends TestCase
{
    /** @test */
    public function it_deletes_an_item_from_the_wishlist()
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();
        $product = ProductVariation::factory()->create();
        $branch->products()->attach($product);
        $user->wishlist()->sync(
            [$product->id => [
                'branch_id' => $branch->id,
                'type' => 'wishlist',
            ]]
        );
        $this->jsonAs($user->fresh(), 'DELETE', route('api.auth.wishlist.destroy', [
            'productVariation' => $product->id,
            'branch' => $branch->id,

        ]))->assertStatus(200);
        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id,
            'type' => 'wishlist',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $branch = Branch::factory()->create();

        $this->delete(route('api.auth.wishlist.destroy', [
            'productVariation' => 100,
            'branch' => $branch->id,

        ]))->assertStatus(401);
    }
}
