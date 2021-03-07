<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Album;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class IndexAlbumsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_albums_with_branch_when_available()
    {
        $this->albumFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.albums.index') . '?include=branch'
        );
        $this->assertTrue(array_key_exists('branch', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_albums_with_user_when_available()
    {
        $this->albumFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.albums.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_albums_by_branch_id()
    {
        $this->albumFactory->count(5)->create([
            'status' => 'active',

        ]);
        $album = $this->albumFactory->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.albums.index'), 'filter[branch.id]', $album->branch_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($album->branch_id, $response->getData(true)['data'][0]['branch_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_albums_by_branch_name()
    {
        $this->albumFactory->count(5)->create([
            'status' => 'active',
        ]);
        $album = $this->albumFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.albums.index'), 'filter[branch.name]', $album->branch->name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($album->branch_id, $response->getData(true)['data'][0]['branch_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_albums_by_name()
    {
        $albums = $this->albumFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.albums.index'), 'filter[name]', $albums->first()->name)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_albums_by_user_id()
    {
        $this->albumFactory->count(5)->create([
            'status' => 'active',

        ]);
        $album = $this->albumFactory->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.albums.index'), 'filter[user.id]', $album->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($album->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->albumFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->albumFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->albumFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.albums.index') . '?sort=created_at'
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
        $this->albumFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->albumFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->albumFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.albums.index') . '?sort=-created_at'
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
        $this->albumFactory = Album::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}
