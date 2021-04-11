<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use App\Common\Transformers\Money;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Order\Entities\Order;
use App\Domain\Order\Notifications\OrderPlaced;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Entities\Address;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use Event;
use Illuminate\Support\Arr;
use Joovlly\Authorizable\Models\Role;
use Notification;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_order_and_return_base_order_resource()
    {
        Event::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $branch = $this->branchFactory->create();
        $branch->products()->attach($products);
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'products' => [
                ['id' => $products->first()->id,
                    'quantity' => 2],
            ],

        ]);
        $response->assertJsonStructure([
            'data' => [
                'status',
                'created_at',
                'subtotal',
                'total',
                'id',
            ],
        ]);

    }

    /**
     * @test
     */
    public function it_should_create_order_with_creator_id_auto_filled()
    {
        Event::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $branch = $this->branchFactory->create();
        $branch->products()->attach($products);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $branch->id,

            'user_id' => $user->id,
            'products' => $products->map(fn($product) => ['id' => $product->id, 'quantity' => 2])->toArray(),

        ]);
        $this->assertDatabaseHas('orders', [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'creator_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function it_should_create_order_with_discount_applied_and_discount_is_applied_to_subtotal()
    {
        Event::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $branch = $this->branchFactory->create();
        $branch->products()->attach($products);
        $discount = $this->discountFactory->doesntExpire()->withCategory()->create();
        $discount->discountable->products()->attach($products);
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
            'products' => $products->map(fn($product) => ['id' => $product->id, 'quantity' => 2])->toArray(),

        ]);
        $subtotal = $products->reduce(function ($carry, $product) {
            return $carry + ($product->price->amount() * 2);
        }, 0);
        $this->assertNotEquals((new Money($subtotal))->formatted(), $response->getData(true)['data']['subtotal']);
    }

    /**
     * @test
     */
    public function it_should_store_order_and_fire_notification_order_placed()
    {
        Notification::fake();
        $products = $this->productVariationFactory->count(3)->withStatus('active')->create();
        $branch = $this->branchFactory->create();
        $branch->products()->attach($products);

        $user = $this->userFactory->create();
        Address::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.orders.store'), [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'branch_id' => $branch->id,

            'products' => $products->map(fn($product) => ['id' => $product->id, 'quantity' => 1])->toArray(),

        ]);
        // dd($response);
        Notification::assertSentTo(
            $user,
            OrderPlaced::class,
            function (OrderPlaced $notification) use ($response) {
                return $notification->order->id === $response->getData(true)['data']['id'];
            }
        );

    }

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function it_shouldnt_store_order_if_unauthenticated()
    {
        $this->post(
            route('api.orders.store'),
            []
        )->assertStatus(401);
    }

    /**
     * @test
     */
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
