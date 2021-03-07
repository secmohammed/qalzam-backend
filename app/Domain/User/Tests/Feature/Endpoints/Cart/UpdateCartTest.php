<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class UpdateCartTest extends TestCase
{
    /** @test */
    public function it_fails_if_product_variation_not_found()
    {
        $this->put(route('api.auth.cart.update', [
            'productVariation' => 1,
            'branch' => $this->branch,
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_requires_a_numeric_quantity()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs($user, 'PUT', route('api.auth.cart.update', [
            'branch' => $this->branch,
            'productVariation' => $product->id,
        ]), [
            'quantity' => 'one',
        ]);
        $this->assertEquals(["The quantity must be a number."], $response->getData(true)['errors']['quantity']);
    }

    /** @test */
    public function it_requires_a_numeric_quantity_of_one_or_more()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT', route('api.auth.cart.update', [
            'branch' => $this->branch,
            'productVariation' => $product->id,
        ]), [
            'quantity' => 0,
        ]);
        $this->assertEquals(["The quantity must be at least 1."], $response->getData(true)['errors']['quantity']);

    }

    /** @test */
    public function it_requires_a_quantity()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs($user, 'PUT', route('api.auth.cart.update', [
            'branch' => $this->branch,
            'productVariation' => $product->id,
        ]));
        $this->assertEquals(["The quantity field is required."], $response->getData(true)['errors']['quantity']);
    }

    /** @test */
    public function it_updates_the_quantity_of_a_product()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
            'status' => 'active',
        ]);
        $user->cart()->sync([
            $product->id => [
                'quantity' => 1,
                'branch_id' => $this->branch->id,
                'type' => 'cart',
            ],
        ]);
        $this->branch->products()->attach($product);
        $response = $this->jsonAs($user, 'PUT', route('api.auth.cart.update', [
            'productVariation' => $product->id,
            'branch' => $this->branch->id,

        ]), [
            'quantity' => $quantity = 5,
        ]);
        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => $quantity,
            'user_id' => $user->id,
            'type' => 'cart',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branch = Branch::factory()->create();
    }
}
