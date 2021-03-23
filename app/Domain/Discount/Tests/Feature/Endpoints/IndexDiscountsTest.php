<?php
namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\Discount\Entities\Discount;

class IndexDiscountsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_discounts_that_arent_expired()
    {
        $this->discountFactory->count(5)->alreadyExpired()->withStatus('active')->create();
        $discounts = $this->discountFactory->count(5)->doesntExpire()->withStatus('active')->create();
        $response = $this->get(
            sprintf('%s?%s', route('api.discounts.index'), 'filter[without_expired]')
        );
        $this->assertEquals(5, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_discounts_by_code()
    {
        $this->discountFactory->count(5)->create();
        $this->discountFactory->create([
            'code' => $code = 'hello',
            'status' => 'active',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.discounts.index'), 'filter[code]', $code)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($code, $response->getData(true)['data'][0]['code']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_discounts_by_percentage_between()
    {
        $this->discountFactory->count(5)->withStatus('active')->create([
            'value' => 10,
        ]);
        $this->discountFactory->count(5)->withStatus('active')->create([
            'value' => 30,
        ]);
        $this->discountFactory->count(5)->withStatus('active')->create([
            'value' => 50,
        ]);
        $this->discountFactory->count(5)->withStatus('active')->create([
            'value' => 70,
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.discounts.index'), 'filter[value_between]', '10,50')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(15, count($response->getData(true)['data']));
    }

    /**  @test */
    public function it_should_list_all_of_active_discounts_paginated_by_default()
    {
        $this->discountFactory->count(5)->withStatus('active')->create();
        $this->discountFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.discounts.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_return_discounts_with_owner_included()
    {
        $discounts = $this->discountFactory->withStatus('active')->create();
        $response = $this->get(
            route('api.discounts.index') . '?include=owner'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('owner', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_return_discounts_with_users_included()
    {
        $discounts = $this->discountFactory->withUsersUsing(3)->withStatus('active')->create();
        $response = $this->get(
            route('api.discounts.index') . '?include=users'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('users', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['users']);
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->discountFactory->withStatus('active')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->discountFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->discountFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.discounts.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_by_created_at_descending()
    {
        $this->discountFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->discountFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->discountFactory->withStatus('active')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.discounts.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->discountFactory = Discount::factory();
    }
}
