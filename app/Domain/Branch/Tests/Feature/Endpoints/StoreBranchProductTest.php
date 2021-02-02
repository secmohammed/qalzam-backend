<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Product;

class StoreBranchProductTest extends TestCase
{
    /** @test */
    public function it_should_update_branch_product_if_authenticated_and_products_exist_and_branch_exist()
    {
        $branch = $this->branchFactory->create();
        $products = $this->productFactory->count(3)->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'POST',
            route('api.branch.products.store', $branch->id), [
                'products' => $products->pluck('id')->toArray(),
            ]
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_update_branch_product_if_authenticated_and_products_arent_supplied()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'POST',
            route('api.branch.products.store', $branch->id), []
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_update_branch_product_if_branch_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'POST',
            route('api.branch.products.store', 1), [
                'products' => [1, 2],
            ]
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_update_branch_product_if_products_dont_exist()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'POST',
            route('api.branch.products.store', $branch->id), [
                'products' => [1, 2],
            ]
        )->assertStatus(422)->assertJsonValidationErrors(['products.0']);

    }

    /** @test */
    public function it_shouldnt_update_branch_product_if_unauthenticated()
    {
        $branch = $this->branchFactory->create();
        $this->post(
            route('api.branch.products.store', $branch->id)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->productFactory = Product::factory();
        $this->branchFactory = Branch::factory();
        $this->userFactory = User::factory();
    }
}
