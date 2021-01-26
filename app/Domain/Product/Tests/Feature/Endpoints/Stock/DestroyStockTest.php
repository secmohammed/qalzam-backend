<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Stock;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;

class DestroyStockTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_stocks_exist()
    {
        $user = $this->userFactory->create();
        $stock = $this->stockFactory->count(2)->withStatus('active')->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $stock->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.stocks.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_stock_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.stocks.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_stock_if_not_having_permission_of_deleting_stock()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.stocks.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_stock_if_unauthenticated()
    {
        $this->delete(
            route('api.stocks.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();
    }
}
