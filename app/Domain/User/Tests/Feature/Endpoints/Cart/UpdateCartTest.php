<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

class UpdateCartTest extends TestCase
{
    /** @test */
    public function it_fails_if_product_variation_not_found()
    {
        $this->put('/api/cart/1')->assertStatus(404);
    }

    /** @test */
    public function it_requires_a_numeric_quantity()
    {
        $user = User::factory()->create();
        $product = ProductVariation::factory()->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs($user, 'PUT', "api/cart/{$product->id}", [
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
        $response = $this->jsonAs($user, 'PUT', "api/cart/{$product->id}", [
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
        $response = $this->jsonAs($user, 'PUT', "api/cart/{$product->id}");
        $this->assertEquals(["The quantity field is required."], $response->getData(true)['errors']['quantity']);
    }

    /** @test */
    public function it_updates_the_quantity_of_a_product()
    {
        $user = User::factory()->create();
        $user->cart()->attach(
            $product = ProductVariation::factory()->create([
                'status' => 'active',
            ]), [
                'quantity' => 1,

            ]
        );
        $response = $this->jsonAs($user, 'PUT', "api/cart/{$product->id}", [
            'quantity' => $quantity = 5,
        ]);
        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => $quantity,
            'user_id' => $user->id,
        ]);
    }
}
