<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class IndexCartTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->get('/api/cart')->assertStatus(401);
    }

    /** @test */
    public function it_shows_a_formatted_subtotal()
    {
        $user = User::factory()->create();

        $this->assertEquals("٠٫٠٠ ج.م.‏", $this->jsonAs($user, 'GET', 'api/cart')->getData(true)['data']['meta']['cart']['subtotal']);
    }

    /** @test */
    public function it_shows_a_formatted_total()
    {
        $user = User::factory()->create();

        $this->assertEquals("٠٫٠٠ ج.م.‏", $this->jsonAs($user, 'GET', 'api/cart')->getData(true)['data']['meta']['cart']['total']);
    }

    /** @test */
    public function it_shows_if_the_cart_is_empty()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/cart')->assertJsonFragment([
            'empty' => true,
        ]);
    }

    /** @test */
    public function it_shows_products_in_the_user_cart()
    {
        $user = User::factory()->create();

        $user->cart()->sync(
            $product = ProductVariation::factory()->create()
        );

        $this->jsonAs($user, 'GET', 'api/cart')->assertJsonFragment([
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function it_syncs_the_cart_test()
    {
        $user = User::factory()->create();
        $user->cart()->attach(
            $product = ProductVariation::factory()->create(), [
                'quantity' => 2,
            ]
        );
        $this->jsonAs($user, 'GET', 'api/cart')->assertJsonFragment([
            'changed' => true,
        ]);
    }
}
