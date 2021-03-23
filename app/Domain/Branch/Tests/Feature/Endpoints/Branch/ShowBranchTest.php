<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Branch;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class ShowBranchTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branch_by_id_if_authenticated_and_has_permissions()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.branches.show', $branch->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'name',
                'id',
                'creator_id',
                'latitude',
                'longitude',
                'location_id',
                'user_id',
                'media',
                'created_at_human',
                'media',
            ],
        ]);

    }

    /** @test */
    public function it_should_fetch_branch_products_and_display_its_price_from_branch_product_table_instead_of_product_variation_price()
    {
        $branch = $this->branchFactory->withProducts(2, [
            'price' => 100,
        ])->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.branches.show', $branch->id) . '?include=products'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'name',
                'id',
                'products',
                'creator_id',
                'latitude',
                'longitude',
                'location_id',
                'user_id',
                'media',
                'created_at_human',
                'media',
            ],
        ]);
        foreach ($response->getOriginalContent()->products as $product) {
            $this->assertDatabaseMissing('product_variations', [
                'price' => 100,
                'id' => $product->id,
            ]);
            $this->assertEquals("10000", $product->price->amount());
        }
    }

    /** @test */
    public function it_shouldnt_fetch_branch_by_id_if_not_found()
    {
        $this->get(
            route('api.branches.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_branch_if_not_authenticated()
    {
        $branch = $this->branchFactory->create();
        $this->get(
            route('api.branches.show', $branch->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.branches.show', $branch->id)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branchFactory = Branch::factory();
        $this->userFactory = User::factory();
    }
}
