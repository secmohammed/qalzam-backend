<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Album;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Album;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class DestroyAlbumTest extends TestCase
{
    /** @test */
    public function it_should_delete_album_when_branch_is_deleted()
    {
        $user = $this->userFactory->create();
        $album = $this->albumFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        Branch::whereId($album->branch_id)->delete();
        $this->assertDatabaseMissing('albums', [
            'id' => $album->id,
            'branch_id' => $album->branch_id,
        ]);
    }

    /** @test */
    public function it_should_delete_album_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $album = $this->albumFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.albums.destroy', $album->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_album_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.albums.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_album_if_not_having_permission_of_deleting_album()
    {
        $album = $this->albumFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.albums.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_album_if_unauthenticated()
    {
        $this->delete(
            route('api.albums.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->albumFactory = Album::factory();
    }
}
