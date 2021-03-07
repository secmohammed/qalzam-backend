<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\UserOrder;

use Event;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Product\Entities\ProductVariation;

class StoreUserOrderTest extends TestCase
{
    /** @test */
    public function it_attaches_the_products_to_the_order()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $user->cart()->sync(
            $product = $this->productWithStock()
        );
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,
        ]);
        $this->assertDatabaseHas('product_variation_order', [
            'product_variation_id' => array_keys($product)[0],
            'order_id' => json_decode($response->getContent())->data->id,
        ]);

    }

    /** @test */
    public function it_can_create_an_order()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );
        $address = $this->addAddressTo($user);
        $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,

        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);
    }

    /** @test */
    public function it_empties_the_cart_after_ordering()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,

        ]);
        $this->assertEmpty($user->cart);
    }

    /** @test */
    public function it_fails_if_not_authenticated()
    {
        $this->json('POST', route('api.user_orders.store'))->assertStatus(401);
    }

    /** @test */
    public function it_fails_to_create_order_if_branch_isnt_set()
    {
        Event::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync($product = $this->productWithStock());
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,

        ])->assertStatus(422);

    }

    /** @test */
    public function it_fails_to_create_order_if_cart_is_empty()
    {
        Event::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync($product = $this->productWithStock(0));
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,
        ])->assertStatus(400);

    }

    /** @test */
    public function it_fires_an_order_created_event()
    {
        Event::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );
        $address = $this->addAddressTo($user);
        $response = $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,

        ]);
        Event::assertDispatched(OrderCreated::class, function ($event) use ($response) {
            return $event->order->id === json_decode($response->getContent())->data->id;
        });
    }

    /** @test */
    public function it_requires_an_address()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );
        $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'branch_id' => $this->branch->id,

        ])->assertJsonValidationErrors(['address_id']);
    }

    /** @test */
    public function it_requires_an_address_that_belongs_to_the_authenticated_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $address = $this->addressFactory->create();
        $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => $address->id,
            'branch_id' => $this->branch->id,

        ])->assertJsonValidationErrors(['address_id']);

    }

    /** @test */
    public function it_requires_an_existing_address()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $this->jsonAs($user, 'POST', route('api.user_orders.store'), [
            'address_id' => 1,
            'branch_id' => $this->branch->id,

        ])->assertJsonValidationErrors(['address_id']);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();
        $this->orderFactory = Order::factory();
        $this->addressFactory = Address::factory();
        $this->branchFactory = Branch::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->branch = $this->branchFactory->create();
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

    /**
     * @return mixed
     */
    protected function productWithStock($quantity = 1)
    {
        $product = $this->productVariationFactory->create();
        $this->stockFactory->create([
            'product_variation_id' => $product->id,
        ]);
        $product->branches()->attach($this->branch, [
            'price' => 130,
        ]);

        return [$product->id => ['branch_id' => $this->branch->id, 'type' => 'cart', 'quantity' => $quantity]];
    }
}
