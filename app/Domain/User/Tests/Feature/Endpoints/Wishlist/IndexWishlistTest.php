<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Wishlist;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class IndexWishlistTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->get(route('api.auth.wishlist.index', $this->branch->id))->assertStatus(401);
    }

    /** @test */
    public function it_shows_products_in_the_user_wishlist()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create();
        $product->branches()->attach($this->branch);
        $user->wishlist()->sync([
            $product->id => [
                'type' => 'wishlist',
                'branch_id' => $this->branch->id,
            ],
        ]);
        $this->jsonAs($user, 'GET', route('api.auth.wishlist.index', $this->branch->id))->assertJsonFragment([
            'id' => $product->id,
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branch = Branch::factory()->create();
    }
}
