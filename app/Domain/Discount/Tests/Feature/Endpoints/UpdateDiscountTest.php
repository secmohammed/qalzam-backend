<?php

namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Discount\Entities\Discount;

class UpdateDiscountTest extends TestCase
{
    /** @test */
    public function it_shouldnt_let_user_update_discount_if_doesnt_exist()
    {
        $this->put(
            route('api.discounts.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_discount_if_doesnt_have_permission()
    {
        $discount = $this->discountFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.discounts.update', $discount->id), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_discount_if_code_of_discount_already_existing()
    {

        $discount = $this->discountFactory->withStatus('active')->create();
        $anotherDiscount = $this->discountFactory->withStatus('active')->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.discounts.update', $discount), [
                'code' => $anotherDiscount->code,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_discount_if_unauthenticated()
    {
        $discount = $this->discountFactory->withStatus('active')->create();
        $this->put(
            route('api.discounts.update', $discount->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->discountFactory = Discount::factory();
    }
}
