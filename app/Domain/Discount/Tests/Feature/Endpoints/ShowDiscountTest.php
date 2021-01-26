<?php

namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Discount\Entities\Discount;

class ShowDiscountTest extends TestCase
{
    /** @test */
    public function it_should_fetch_discount_by_id()
    {
        $discount = $this->discountFactory->withStatus('active')->create();
        $this->get(
            route('api.discounts.show', $discount->id)
        )->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'expires_at_human',
                'number_of_usage',
                'percentage',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_discount_by_id_if_not_currently_active()
    {
        $discount = $this->discountFactory->withStatus('inactive')->create();
        $this->get(
            route('api.discounts.show', $discount->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_discount_by_id_if_not_found()
    {
        $this->get(
            route('api.discounts.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->discountFactory = Discount::factory();
    }
}
