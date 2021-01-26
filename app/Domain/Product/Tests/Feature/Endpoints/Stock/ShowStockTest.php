<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Stock;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;

class ShowStockTest extends TestCase
{
    /** @test */
    public function it_should_let_user_see_stock_if_not_authenticated()
    {
        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.stocks.show', $stock)
        )->assertStatus(200);
    }

    /** @test */
    public function it_should_see_stock_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.show', $stock)
        )->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'quantity',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_stock_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.show', $stock) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_stock_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $stock = $this->stockFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.show', $stock)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_stock_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $stock = $this->stockFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.stocks.show', $stock)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();

    }
}
