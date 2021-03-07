<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Album;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class ShowAlbumTest extends TestCase
{
    /** @test */
    public function it_should_fetch_album_by_id_if_authenticated_and_has_permissions()
    {
        $album = $this->albumFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.albums.show', $album->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'user_id',
                'branch_id',
                'media',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_fetch_album_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.albums.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_album_if_not_authenticated()
    {
        $album = $this->albumFactory->create();
        $this->get(
            route('api.albums.show', $album->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $album = $this->albumFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.albums.show', $album->id)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->albumFactory = Album::factory();
        $this->userFactory = User::factory();
    }
}
