<?php

namespace App\Domain\Order\Tests\Unit\Entities;

use Tests\TestCase;
use App\Common\Transformers\Money;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use App\Domain\Product\Entities\ProductVariation;

class OrderTest extends TestCase
{
    /** @test */
    public function it_adds_shipping_onto_the_total()
    {
        $user = $this->userFactory->create();
        $order = $this->orderFactory->create([
            'user_id' => $user->id,
            'subtotal' => 1000,
        ]);
        $this->assertEquals($order->total()->amount(), 1000);
    }

    /** @test */
    public function it_belongs_a_user()
    {
        $user = $this->userFactory->create();

        $order = $this->orderFactory->create([
            'user_id' => $user->id,
        ]);
        $this->assertInstanceOf(User::class, $order->user);
    }

    /** @test */
    public function it_belongs_an_address()
    {
        $user = $this->userFactory->create();

        $order = $this->orderFactory->create([
            'user_id' => $user->id,
        ]);
        $this->assertInstanceOf(Address::class, $order->address);
    }

    /** @test */
    public function it_has_a_default_status_of_pending()
    {
        $user = $this->userFactory->create();
        $order = $this->orderFactory->create([
            'user_id' => $user->id,
        ]);
        $this->assertEquals($order->fresh()->status, Order::PENDING);
    }

    /** @test */
    public function it_has_a_quantity_attached_to_the_products()
    {
        $order = $this->orderFactory->create([

            'user_id' => $this->userFactory->create()->id,
        ]);
        $order->products()->attach(
            $this->productVariationFactory->create(), [
                'quantity' => $quantity = 1,
            ]
        );
        $this->assertEquals($order->products->first()->pivot->quantity, $quantity);
    }

    /** @test */
    public function it_has_many_products()
    {
        $order = $this->orderFactory->create([

            'user_id' => $this->userFactory->create()->id,
        ]);
        $order->products()->attach(
            $this->productVariationFactory->create(), [
                'quantity' => 1,
            ]
        );
        $this->assertInstanceOf(ProductVariation::class, $order->products->first());
    }

    /** @test */
    public function it_returns_a_money_instance_for_subtotal()
    {
        $user = $this->userFactory->create();
        $order = $this->orderFactory->create([
            'user_id' => $user->id,
        ]);
        $this->assertInstanceOf(Money::class, $order->subtotal);
    }

    /** @test */
    public function it_returns_a_money_instance_for_total()
    {
        $user = $this->userFactory->create();
        $order = $this->orderFactory->create([
            'user_id' => $user->id,
        ]);
        $this->assertInstanceOf(Money::class, $order->total());

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
        $this->productVariationFactory = ProductVariation::factory();
    }
}
