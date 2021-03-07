<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Cart;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class StoreCartTest extends TestCase
{
    /** @test */
    public function it_can_add_products_to_the_users_cart()
    {
        $user = $this->userFactory->create();
        $product = $this->productVariationFactory->create();
        $this->branch->products()->attach($product);
        $response = $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => [
                ['id' => $product->id, 'quantity' => 2],
            ],
        ]);
        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function it_fails_if_user_is_unauthenticated()
    {
        $this->post(route('api.auth.cart.store', $this->branch->id))->assertStatus(401);
    }

    /** @test */
    public function it_requires_products()
    {
        $user = $this->userFactory->create();

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id))
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_quantity_to_be_at_least_one()
    {
        $user = $this->userFactory->create();
        $product = $this->productVariationFactory->create();
        $this->branch->products()->attach($product);

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => [
                ['id' => $product->id, 'quantity' => 0],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    /** @test */
    public function it_requires_products_quantity_to_be_numeric()
    {
        $user = $this->userFactory->create();

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => [
                ['id' => 1, 'quantity' => 'abc'],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    /** @test */
    public function it_requires_products_to_be_an_array()
    {
        $user = $this->userFactory->create();

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => 1,
        ])
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_have_an_id()
    {
        $user = $this->userFactory->create();

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => [
                ['quantity' => 1],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    /** @test */
    public function it_requires_products_to_exist()
    {
        $user = $this->userFactory->create();

        $this->jsonAs($user, 'POST', route('api.auth.cart.store', $this->branch->id), [
            'products' => [
                ['id' => 1, 'quantity' => 1],
            ],
        ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->branchFactory = Branch::factory();
        $this->branch = $this->branchFactory->create();
    }
}
