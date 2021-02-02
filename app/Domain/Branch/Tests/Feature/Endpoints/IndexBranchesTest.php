<?php
namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class IndexBranchesTest extends TestCase
{
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
    public function it_should_fetch_branches_with_products_when_available()
    {
        $this->branchFactory->create();
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branches.index') . '?include=products'
        );
        $this->assertTrue(array_key_exists('products', $response->getData(true)['data'][0]));

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
    public function it_should_filter_branches_by_products_id()
    {
        $product = Product::factory()->create();
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
