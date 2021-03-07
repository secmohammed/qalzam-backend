<?php

namespace App\Domain\User\Tests\Unit\Entities;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;

class UserTest extends TestCase
{
    /** @test */
    public function it_fetches_user_cart()
    {
        $user = $this->userFactory->create();
        $productVariation = $this->productVariationFactory->create();
        $branch = Branch::factory()->create();
        $user->cart()->attach(
            $productVariation->id, [
                'branch_id' => $branch->id,
                'type' => 'cart',
            ]
        );
        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    /** @test */
    public function it_has_a_quantity_for_each_product()
    {
        $user = $this->userFactory->create();
        $branch = Branch::factory()->create();

        $user->cart()->attach(
            $this->productVariationFactory->create(), [
                'quantity' => $quantity = 5,
                'branch_id' => $branch->id,
                'type' => 'cart',

            ]
        );
        $this->assertEquals($quantity, $user->cart->first()->pivot->quantity);
    }

    /** @test */
    public function it_has_many_addresses()
    {
        $user = $this->userFactory->create();
        $user->addresses()->save(
            $this->addressFactory->make()
        );
        $this->assertInstanceOf(Address::class, $user->addresses->first());
    }

    /** @test */
    public function it_has_many_orders()
    {
        $user = $this->userFactory->create();
        $user->orders()->save(
            $this->orderFactory->make()
        );
        $this->assertInstanceOf(Order::class, $user->orders->first());
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->orderFactory = Order::factory();
        $this->addressFactory = Address::factory();

    }
}
