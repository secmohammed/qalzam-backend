<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\BranchProductVariation;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariation;

class ShowBranchProductVariationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_404_if_branch_doenst_exist()
    {
        $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.products.show', ['branch' => 1, 'product' => $this->productVariationFactory->create()->id])
        )->assertStatus(404);

    }

    /**
     * @test
     */
    public function it_should_return_404_if_product_variation_doesnt_exist()
    {
        $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.products.show', ['branch' => $this->branchFactory->create()->id, 'product' => 1])
        )->assertStatus(404);

    }

    /**
     * @test
     */
    public function it_should_return_error_message_if_product_variation_doesnt_belong_to_the_showing_branch()
    {
        $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.products.show', ['branch' => $this->branchFactory->create([
            ])->id, 'product' => $this->productVariationFactory->create([
                'status' => 'active',
            ])->id])
        )->assertStatus(422);

    }

    /**
     * @test
     */
    public function it_should_show_product_variation_if_exists_and_belongs_to_the_showing_branch()
    {
        $branch = $this->branchFactory->create();
        $branch->products()->attach(
            $product = $this->productVariationFactory->create([
                'status' => 'active',
                'price' => 200, // variation price
            ]), [
                'price' => 100, // price of the product at the branch, representing a different price at the menu of this branch.
            ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.products.show', ['branch' => $branch->id, 'product' => $product->id])
        )->assertStatus(200);
        $this->assertDatabaseMissing('product_variations', [
            'id' => $product->id,
            'price' => (int) $response->getOriginalContent()->price->amount() / 100,
        ]);
        $this->assertDatabaseHas('branch_product', [
            'product_variation_id' => $product->id,
            'branch_id' => $branch->id,
            'price' => (int) $response->getOriginalContent()->price->amount() / 100,
        ]);
    }

    /**
     * @test
     */
    public function it_shouldnt_show_branch_product_variation_if_unauthenticated()
    {
        $this->get(
            route('api.branches.products.show', ['branch' => $this->branchFactory->create([

            ])->id, 'product' => $this->productVariationFactory->create([
                'status' => 'active',
            ])->id])

        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->user = $this->userFactory->create();
        $this->branchFactory = Branch::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}
