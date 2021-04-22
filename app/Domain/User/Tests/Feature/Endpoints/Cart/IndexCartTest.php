<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Entities\ProductVariation;

class IndexCartTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->get(route('api.auth.cart.index', $this->branch->id))->assertStatus(401);
    }

    /** @test */
    public function it_shows_a_formatted_subtotal()
    {
        $user = User::factory()->create();
        $products = ProductVariation::factory()->count(3)->create();
        $products->each(function ($product) {
            Stock::factory()->create([
                'product_variation_id' => $product->id,
                'quantity' => 100
            ]);
        });
        $mappedProducts = $products->keyBy('id')->map(fn () => [
            'quantity' => 1,
            'type' => 'cart',
            'branch_id' => $this->branch->id
        ]);
        $otherProducts = ProductVariation::factory()->count(3)->create();
        $otherProducts->each(function ($product) {
            Stock::factory()->create([
                'product_variation_id' => $product->id,
                'quantity' => 100
            ]);
        });
        $branch = Branch::factory()->create();
        $otherMappedProducts = $otherProducts->keyBy('id')->map(fn () => [
            'quantity' => 1,
            'type' => 'cart',
            'branch_id' => $branch->id
        ]);
        $this->branch->products()->attach($products);
        $user->cart()->attach($mappedProducts);
        $user->cart()->attach($otherMappedProducts);
        $this->assertNotEquals('٠٫٠٠ ر.س.‏', $this->jsonAs($user, 'GET', route('api.auth.cart.index', $this->branch->id))->getData(true)['data']['meta']['cart']['subtotal']);
    }

    /** @test */
    public function it_shows_a_formatted_total_with_delivery_fee()
    {
        $user = User::factory()->create();

        $this->assertEquals('٠٫٠٠ ر.س.‏', $this->jsonAs($user, 'GET', route('api.auth.cart.index', $this->branch->id))->getData(true)['data']['meta']['cart']['total']);
    }

    /** @test */
    public function it_shows_if_the_cart_is_empty()
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', route('api.auth.cart.index', $this->branch->id))->assertJsonFragment([
            'empty' => true,
        ]);
    }

    /** @test */
    public function it_shows_products_in_the_user_cart()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
        ]);
        $product->branches()->attach($this->branch->id);
        $user->cart()->sync([
            $product->id => ['branch_id' => $this->branch->id, 'type' => 'cart', 'quantity' => 3],
        ]);

        $this->jsonAs($user, 'GET', route('api.auth.cart.index', $this->branch->id))->assertJsonFragment([
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
                'type' => 'cart',
                'branch_id' => $this->branch->id,
            ]
        );
        $product->branches()->attach($this->branch->id);

        $this->jsonAs($user, 'GET', route('api.auth.cart.index', $this->branch->id))->assertJsonFragment([
            'changed' => true,
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branch = Branch::factory()->create();
    }
}
