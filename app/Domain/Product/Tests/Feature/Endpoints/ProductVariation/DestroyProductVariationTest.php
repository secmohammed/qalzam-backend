<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\ProductVariation;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariation;

class DestroyProductVariationTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_product_variations_exist()
    {
        $user = $this->userFactory->create();
        $product_variation = $this->productVariationFactory->count(2)->withStatus('active')->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $product_variation->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.product_variations.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_product_variation_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.product_variations.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_product_variation_if_not_having_permission_of_deleting_product_variation()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.product_variations.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_product_variation_if_unauthenticated()
    {
        $this->delete(
            route('api.product_variations.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
    }
}
