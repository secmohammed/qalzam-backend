<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use Event;
use Tests\TestCase;
use Illuminate\Support\Arr;
use App\Common\Transformers\Money;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Product\Entities\ProductVariation;

class StoreOrderTest extends TestCase
{
    /** @test */
    public function it_should_create_order_and_return_base_order_resource()
    {
        Event::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'branch_id' => $this->branchFactory->create()->id,
            'products' => [
                ['id' => $products->first()->id,
                    'quantity' => 2],
            ],

        ])->assertJsonStructure([
            'data' => [
                'status',
                'created_at',
                'subtotal',
                'total',
                'id',
            ],
        ]);
    }

    /** @test */
    public function it_should_create_order_with_creator_id_auto_filled()
    {
        Event::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branchFactory->create()->id,

            'user_id' => $user->id,
            'products' => $products->pluck('id')->toArray(),

        ]);
        $this->assertDatabaseHas('orders', [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'creator_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_should_create_order_with_discount_applied_and_discount_is_applied_to_subtotal()
    {
        Event::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $branch = $this->branchFactory->create();
        $branch->products()->attach($products);
        $discount = $this->discountFactory->doesntExpire()->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->discounts()->attach($discount);
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'discount_id' => $discount->id,
            'branch_id' => $branch->id,

            'products' => $products->pluck('id')->toArray(),

        ]);
        $subtotal = $products->reduce(function ($carry, $product) {
            return $carry + $product->price->amount();
        }, 0);
        $this->assertNotEquals((new Money($subtotal))->formatted(), $response->getData(true)['data']['subtotal']);
    }

    /** @test */
    public function it_should_store_order_and_fire_order_created_event()
    {
        Event::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'branch_id' => $this->branchFactory->create()->id,

            'products' => $products->pluck('id')->toArray(),

        ]);
        Event::assertDispatched(OrderCreated::class, function ($event) use ($response) {
            return $event->order->id === json_decode($response->getContent())->data->id;
        });
    }

    /** @test */
    public function it_shouldnt_store_order_if_address_id_doesnt_belong_to_the_attached_user_id()
    {
        $user = $this->userFactory->create();
        $address = $this->addressFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->make([
            'address_id' => $address->id,
        ]);

        $this->jsonAs(
            $user,
            'POST',
            route('api.orders.store'),
            $order->toArray()
        )->assertJsonValidationErrors([
            'address_id',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_order_if_address_id_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->make([
            'address_id' => 1000,
        ]);

        $this->jsonAs(
            $user,
            'POST',
            route('api.orders.store'),
            $order->toArray()
        )->assertJsonValidationErrors([
            'address_id',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_order_if_discount_id_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->make([
            'address_id' => $this->addAddressTo($user),
            'discount_id' => 1000,
        ]);

        $this->jsonAs(
            $user,
            'POST',
            route('api.orders.store'),
            $order->toArray()
        )->assertJsonValidationErrors([
            'discount_id',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_order_if_unauthenticated()
    {
        $this->post(
            route('api.orders.store'),
            []
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_order_if_user_id_isnt_passed()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = Arr::except($this->orderFactory->make([
            'address_id' => $this->addAddressTo($user),
        ]), ['user_id']);
        $this->jsonAs(
            $user,
            'POST',
            route('api.orders.store'),
            $order->toArray()
        )->assertJsonValidationErrors([
            'user_id',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->addressFactory = Address::factory();
        $this->discountFactory = Discount::factory();
        $this->branchFactory = Branch::factory();
    }

    /**
     * @param User $user
     */
    protected function addAddressTo(User $user)
    {
        $address = $this->addressFactory->create([
            'user_id' => $user->id,
        ]);

        return $address;
    }
}
