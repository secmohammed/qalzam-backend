<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Product;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class DestroyProductTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_products_exist()
    {
        $user = $this->userFactory->create();
        $products = $this->productFactory->count(2)->withStatus('active')->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $products->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.products.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_product_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.products.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_product_if_unauthenticated()
    {
        $this->delete(
            route('api.products.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.products.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productFactory = Product::factory();
    }
}
