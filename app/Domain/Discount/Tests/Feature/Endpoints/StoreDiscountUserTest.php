<?php

namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Discount\Entities\Discount;

class StoreDiscountUserTest extends TestCase
{
    /** @test */
    public function it_should_let_user_purchase_discount_if_not_expired_and_not_havent_purchased_before_and_not_owner_of_the_discount_and_active()
    {
        $discount = $this->discountFactory->withStatus('active')->doesntExpire()->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_let_user_purchase_discount_if_discount_is_already_expired()
    {
        $discount = $this->discountFactory->withStatus('active')->alreadyExpired()->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertJsonFragment([
            'message' => "Discount is already expired.",
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_purchase_discount_if_discount_is_already_purchased()
    {
        $discount = $this->discountFactory->withStatus('active')->doesntExpire()->create();
        $discount->users()->attach($user = $this->userFactory->create(), ['used_at' => now()]);
        $this->jsonAs($user, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertJsonFragment([
            'message' => "Discount cannot be purchased.",
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_purchase_discount_if_discount_is_currently_inactive()
    {
        $discount = $this->discountFactory->withStatus('inactive')->doesntExpire()->create();
        $this->jsonAs($discount->owner, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertJsonFragment([
            'message' => "Discount is either being inactive currently or it's out of stock at the moment.",
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_purchase_discount_if_discount_is_owned_by_same_user()
    {
        $discount = $this->discountFactory->withStatus('active')->doesntExpire()->create();
        $this->jsonAs($discount->owner, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertJsonFragment([
            'message' => "Discount cannot be purchased.",
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_purchase_discount_if_there_is_no_more_remaining_slot_of_discount()
    {
        $discount = $this->discountFactory->withStatus('active')->doesntExpire()->create([
            'number_of_usage' => 0,
        ]);
        $this->jsonAs($discount->owner, 'POST',
            'api/user_discounts',
            [
                'code' => $discount->code,
            ])->assertJsonFragment([
            'message' => "Discount is either being inactive currently or it's out of stock at the moment.",
        ]);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->discountFactory = Discount::factory();
        $this->userFactory = User::factory();
    }
}
