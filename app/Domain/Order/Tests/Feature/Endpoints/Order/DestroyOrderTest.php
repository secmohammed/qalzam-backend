<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use Queue;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Order\Http\Listeners\RollbackStock;

class DestroyOrderTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_orders_exist()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $orders = $this->orderFactory->count(2)->withStatus('pending')->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $orders->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.orders.destroy', $ids)
        )->assertStatus(200);
        Queue::assertPushed(\Illuminate\Events\CallQueuedListener::class, function ($job) {
            return $job->class === RollbackStock::class && $job->data[0]->orders->first()->products !== null;
        });
    }

    /** @test */
    public function it_shouldnt_destroy_order_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.orders.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_order_if_unauthenticated()
    {
        $this->delete(
            route('api.orders.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.orders.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
    }
}
