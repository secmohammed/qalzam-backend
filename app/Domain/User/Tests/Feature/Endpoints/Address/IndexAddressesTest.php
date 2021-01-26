<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Address;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;

class IndexAddressesTest extends TestCase
{
    /** @test */
    public function it_should_filter_by_default_address()
    {
        $user = $this->userFactory->create();
        $this->addressFactory->count(5)->create([
            'user_id' => $user->id,
            'status' => 'active',
            'default' => false,
        ]);
        $this->addressFactory->count(5)->create([
            'user_id' => $user->id,
            'status' => 'active',
            'default' => true,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.addresses.index') . '?filter[default]=true'
        )->assertJsonStructure([
            'data',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_addresses_paginated_by_default()
    {
        $user = $this->userFactory->create();
        $this->addressFactory->count(5)->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.addresses.index')
        )->assertJsonStructure([
            'data',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->addressFactory = Address::factory();
        $this->userFactory = User::factory();
    }
}
