<?php
namespace App\Domain\Accommodation\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Accommodation;

class IndexAccommodationsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_accommodations_with_branch_when_available()
    {
        $this->accommodationFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.accommodations.index') . '?include=branch'
        );
        $this->assertTrue(array_key_exists('branch', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_accommodations_with_user_when_available()
    {
        $this->accommodationFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.accommodations.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_accommodations_by_branch_id()
    {
        $this->accommodationFactory->count(5)->create();
        $accommodation = $this->accommodationFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[branch.id]', $accommodation->branch_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($accommodation->branch_id, $response->getData(true)['data'][0]['branch_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_accommodations_by_capacity()
    {
        $accommodations = $this->accommodationFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[capacity]', $accommodations->first()->capacity)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_accommodations_by_code()
    {
        $accommodations = $this->accommodationFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[code]', $accommodations->first()->code)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_accommodations_by_name()
    {
        $accommodations = $this->accommodationFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[name]', $accommodations->first()->name)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_accommodations_by_price()
    {
        $accommodations = $this->accommodationFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[price]', $accommodations->first()->price)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_accommodations_by_type()
    {
        $accommodations = $this->accommodationFactory->count(3)->create([
            'type' => 'room',
        ]);
        $this->accommodationFactory->count(3)->create([
            'type' => 'table',
        ]);

        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[type]', 'table')
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_accommodations_by_user_id()
    {
        $this->accommodationFactory->count(5)->create();
        $accommodation = $this->accommodationFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.accommodations.index'), 'filter[user.id]', $accommodation->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($accommodation->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->accommodationFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->accommodationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->accommodationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.accommodations.index') . '?sort=created_at'
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
        $this->accommodationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->accommodationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->accommodationFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.accommodations.index') . '?sort=-created_at'
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
        $this->accommodationFactory = Accommodation::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}
