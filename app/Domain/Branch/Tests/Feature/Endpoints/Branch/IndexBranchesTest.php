<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Branch;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariation;

class IndexBranchesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branches_with_albums_when_available()
    {
        $this->branchFactory->withAlbums()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=albums'
        );
        $this->assertTrue(array_key_exists('albums', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_creator_when_available()
    {
        $this->branchFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=creator'
        );
        $this->assertTrue(array_key_exists('creator', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_deliverers_when_available()
    {
        $this->branchFactory->withDeliverers()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=deliverers'
        );
        $this->assertTrue(array_key_exists('deliverers', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_employees_when_available()
    {
        $this->branchFactory->withEmployees()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=employees'
        );
        $this->assertTrue(array_key_exists('employees', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_location_when_available()
    {
        $this->branchFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=location'
        );
        $this->assertTrue(array_key_exists('location', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_orders_when_available()
    {
        $this->branchFactory->withOrders()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=orders'
        );
        $this->assertTrue(array_key_exists('orders', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_products_when_available()
    {
        $this->branchFactory->withProducts()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=products'
        );
        $this->assertTrue(array_key_exists('products', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_shifts_when_available()
    {
        $this->branchFactory->withShift()->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=shifts'
        );
        $this->assertTrue(array_key_exists('shifts', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_user_when_available()
    {
        $this->branchFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_branches_by_album_name()
    {
        $this->branchFactory->count(5)->withAlbums()->create();
        $branch = $this->branchFactory->withAlbums()->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[albums.name]', $branch->albums->first()->name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_creator_id()
    {
        $this->branchFactory->count(5)->create();
        $branch = $this->branchFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[creator.id]', $branch->creator_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($branch->creator_id, $response->getData(true)['data'][0]['creator_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_delivery_id()
    {
        $this->branchFactory->count(5)->withDeliverers()->create();
        $branch = $this->branchFactory->withDeliverers()->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s&include=%s', route('api.branches.index'), 'filter[deliverers.id]', $branch->deliverers->first()->id, 'deliverers')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
        $this->assertDatabaseHas('role_user', [
            'role_id' => Role::whereSlug('delivery')->first()->id,
            'user_id' => $response->getData(true)['data'][0]['deliverers'][0]['id'],
        ]);
    }

    /** @test */
    public function it_should_filter_branches_by_employee_id()
    {
        $this->branchFactory->count(5)->withEmployees()->create();
        $branch = $this->branchFactory->withEmployees()->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[employees.id]', $branch->employees->first()->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_location_id()
    {
        $this->branchFactory->count(5)->create();
        $branch = $this->branchFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[location.id]', $branch->location_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($branch->location_id, $response->getData(true)['data'][0]['location_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_name()
    {
        $brnaches = $this->branchFactory->count(3)->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[name]', $brnaches->first()->name)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_branches_by_order_id()
    {
        $this->branchFactory->count(5)->withOrders()->create();
        $branch = $this->branchFactory->withOrders()->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[orders.id]', $branch->orders->first()->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_products_id()
    {
        $product = ProductVariation::factory()->create();
        $branches = $this->branchFactory->count(5)->create();
        $branches->first()->products()->attach($product);
        $branch = $this->branchFactory->withProducts(3)->create([
            'name' => 'hello',
        ]);
        $branch->products()->attach($product);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[products.id]', $product->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(2, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_shift_day()
    {
        $this->branchFactory->withShift(1, [
            'day' => 'sunday',
        ])->create();
        $this->branchFactory->withShift(1, [
            'day' => 'monday',
        ])->create();
        $branch = $this->branchFactory->withShift(1, [
            'day' => 'tuesday',
        ])->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[shifts.day]', $branch->shifts->first()->day)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_shift_id()
    {
        $this->branchFactory->count(5)->withShift()->create();
        $branch = $this->branchFactory->withShift()->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[shifts.id]', $branch->shifts->first()->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_user_id()
    {
        $this->branchFactory->count(5)->create();
        $branch = $this->branchFactory->create([
            'name' => 'hello',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[user.id]', $branch->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($branch->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->branchFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?sort=created_at'
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
        $this->branchFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?sort=-created_at'
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
        $this->branchFactory = Branch::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}
